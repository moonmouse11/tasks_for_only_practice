<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин \"Парсер вакансий\"");

CModule::IncludeModule('iblock');

$IBLOCK_ID = 26;
$el = new CIBlockElement;
$arProps = [];

$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE" => "Y", "IBLOCK_ID" => $IBLOCK_ID));
while ($prop_fields = $properties->GetNext()) {
    if ($prop_fields["PROPERTY_TYPE"] !== "L") {
        continue;
    }
    $property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID" => $IBLOCK_ID, "CODE" => $prop_fields["CODE"]));
    while ($enum_fields = $property_enums->GetNext()) {
        $arProps[$prop_fields["CODE"]][$enum_fields["VALUE"]] = $enum_fields["ID"];
    }
}



if (($file = fopen("res/vacancy.csv", "r")) !== false) {
    $line = 1;
    while (($data = fgetcsv($file, 1000, ",")) !== false) {
        if ($line == 1) {
            $line++;
            continue;
        }
        $line++;

        $PROP['ACTIVITY'] = $data[9];
        $PROP['FIELD'] = $data[11];
        $PROP['OFFICE'] = $data[1];
        $PROP['LOCATION'] = $data[2];
        $PROP['REQUIRE'] = explode("•", $data[4]);
        $PROP['DUTY'] = explode("•", $data[5]);
        $PROP['CONDITIONS'] = explode("•", $data[6]);
        $PROP['EMAIL'] = $data[12];
        $PROP['DATE'] = date('d.m.Y');
        $PROP['TYPE'] = $data[8];
        $PROP['SCHEDULE'] = $data[10];
        $PROP['SALARY_TYPE'] = "";
        $PROP['SALARY_VALUE'] = $data[7];

        if ($PROP['SALARY_VALUE'] == '-' || !$PROP['SALARY_VALUE']) {
            $PROP['SALARY_VALUE'] = '';
        } elseif ($PROP['SALARY_VALUE'] == 'по договоренности') {
            $PROP['SALARY_VALUE'] = '';
            $PROP['SALARY_TYPE'] = $arProps['SALARY_TYPE']['договорная'];
        } else {
            $arSalary = explode(' ', $PROP['SALARY_VALUE']);
            if ($arSalary[0] == 'от' || $arSalary[0] == 'до') {
                $PROP['SALARY_TYPE'] = $arProps['SALARY_TYPE'][$arSalary[0]];
                array_splice($arSalary, 0, 1);
                $PROP['SALARY_VALUE'] = implode(' ', $arSalary);
            } else {
                $PROP['SALARY_TYPE'] = $arProps['SALARY_TYPE']['='];
            }
        }

        foreach ($PROP as $key => $value) {
            if (!$arProps[$key]) {
                continue;
            }

            foreach ($arProps[$key] as $prop_key => $prop_value) {
                $value = mb_strtolower(trim($value));
                $prop_key = mb_strtolower(trim($prop_key));
                if ($key === "LOCATION") {
                    $prop_key = explode(",", $prop_key)[0];
                }
                if ($value == $prop_key) {
                    $PROP[$key] = $prop_value;
                    break;
                }
            }
        }

        $arLoadProductArray = array(
            "MODIFIED_BY"    => $USER->GetID(),
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID"      => $IBLOCK_ID,
            "PROPERTY_VALUES" => $PROP,
            "NAME"           => $data[3],
            "ACTIVE"         => end($data) ? 'Y' : 'N',
        );

        if ($PRODUCT_ID = $el->Add($arLoadProductArray))
            echo "New ID: " . $PRODUCT_ID . "<br>";
        else
            echo "Error: " . $el->LAST_ERROR;
    }
    fclose($file);
}
