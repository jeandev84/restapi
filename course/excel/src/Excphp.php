<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excphp
{

    public function genDoc()
    {
        // Создаем новый Spreadsheet объект
        $spreadsheet = new Spreadsheet();

        // Подключение к активной таблице
        $sheet = $spreadsheet->getActiveSheet();

        // Объединяем ячейки от A1:F1
        $sheet->mergeCells("A1:F1");

        // Устанавливаем значение ячейке A1
        $sheet->setCellValue("A1", "Стоимость работ");

        // Установка значений в шапку таблицы
        $sheet->setCellValue("A2", "№ п/п");
        $sheet->setCellValue("B2", "Наименование работ/материалов");
        $sheet->setCellValue("C2", "Ед. изм");
        $sheet->setCellValue("D2", "Кол-во");
        $sheet->setCellValue("E2", "Стоимость");
        $sheet->setCellValue("F2", "Сумма");

        // Установка 1-го ряда значений в таблицу
        $sheet->setCellValue("A3", "1");
        $sheet->setCellValue("B3", "Укладка асфальта");
        $sheet->setCellValue("C3", "м3");
        $sheet->setCellValue("D3", "100");
        $sheet->setCellValue("E3", "500");
        $sheet->setCellValue("F3", "50000");

        // Установка 2-го ряда значений в таблицу
        $sheet->setCellValue("A4", "2");
        $sheet->setCellValue("B4", "Доставка асфальта");
        $sheet->setCellValue("C4", "м3");
        $sheet->setCellValue("D4", "100");
        $sheet->setCellValue("E4", "1000");
        $sheet->setCellValue("F4", "100000");

        // получение текущей даты, будет использоваться в имени файла
        $dt = date("h:i:s");

        // создание объекта Xlsx
        $writer = new Xlsx($spreadsheet);

        // если требуется сохранять файл на сервер, то удалите комментарий у строки ниже
        // $writer->save("file-$dt.xlsx");

        // отправка файла в браузер
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="file-' . $dt . '.xlsx"');
        $writer->save('php://output');
    }

}