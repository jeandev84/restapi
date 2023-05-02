<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excphp{

    public function genDoc($arrToWrite)
    {
        // Создаем новый Spreadsheet объект
        $spreadsheet = new Spreadsheet();

        // Подключение к активной таблице
        $sheet = $spreadsheet->getActiveSheet();

        // Объединяем ячейки от A1:F1
        $sheet->mergeCells("A1:F1");

        // Устанавливаем значение ячейке A1
        $sheet->setCellValue("A1", "Стоимость строительный работ");

        // Установка значений в шапку таблицы
        $sheet->setCellValue("A2", "№ п/п");
        $sheet->setCellValue("B2", "Наименование работ/материалов");
        $sheet->setCellValue("C2", "Ед. изм");
        $sheet->setCellValue("D2", "Кол-во");
        $sheet->setCellValue("E2", "Стоимость");
        $sheet->setCellValue("F2", "Сумма");

        // получаем номер последней строки с записью и прибавляем 1, чтобы писать на следующей строке
        $highestRow = $sheet->getHighestRow() + 1;

        // цикл по массиву, наполняем таблицу
        foreach($arrToWrite as $key => $value){
            $sheet->setCellValue("A$highestRow", "$key");
            $sheet->setCellValue("B$highestRow", "{$value['NAME']}");
            $sheet->setCellValue("C$highestRow", "{$value['UNIT']}");
            $sheet->setCellValue("D$highestRow", "{$value['QUANTITY']}");
            $sheet->setCellValue("E$highestRow", "{$value['PRICE']}");
            $sheet->setCellValue("F$highestRow", "=D$highestRow*E$highestRow");

            // увеличиваем значение последней линии
            $highestRow ++;
        }

        // Выведем внизу таблицы итого, еще раз считаем последнюю строку и прибавим единицу
        $highestRow = $sheet->getHighestRow() + 1;

        // Объединяем ячейки от A:E
        $sheet->mergeCells("A$highestRow:E$highestRow");

        // В объединенную ячейку запишем слово "итого"
        $sheet->setCellValue("A$highestRow", "Итого");

        // запишем формулу с суммой, по колонке F, в этом же ряду
        // мы знаем, что начинается наполняться данными таблица с 3-го ряда
        $SUMRANGE = 'F3:F' . ($highestRow - 1);
        $sheet->setCellValue("F$highestRow", "=SUM($SUMRANGE)");

        // увеличим ширину ячейки B (Наименование работ/материалов)
        $sheet->getColumnDimension('B')->setWidth(70);

        // стилевое оформление шапки таблицы
        // подготовка массива для задания стилей
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'FFFFFF',
                ],
            ],
        ];

        // Установка стилей для строки
        $spreadsheet->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleArray);

        // получение даты, будет использоваться в имени файла
        $dt = date("h:i:s");

        // создание объекта Xlsx
        $writer = new Xlsx($spreadsheet);

        // если требуется сохранять файл на сервер, то раскомментируйте строку ниже
        // $writer->save("file-$dt.xlsx");

        // отправка файла в браузер
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="file-'.$dt.'.xlsx"');
        $writer->save('php://output');
    }

}