<?php
namespace App\Imports;

use App\Models\PluginParkingReservation;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ParkingImport implements ToCollection , WithColumnFormatting
{
    public function collection(Collection $rows)
    {
        PluginParkingReservation::truncate();

        $i = 0;
        foreach ($rows as $row)
        {
            /*  0 => "ID"
            1 => "TIPO"
            2 => "DATA_INGRESSO"
            3 => "ORA_ARRIVO"
            4 => "DATA_USCITA"
            5 => "ORA_USCITA"
            6 => "NOME_COGNOME"
            7 => "TELEFONO"
            8 => "EMAIL"
            9 => "NR_VOLO"
            10 => "NR_PASSEGGERI"
            11 => "TARGA"
            12 => "NR_GG"
            13 => "IMPORTO"
            14 => "ID_AGENZIA"
            15 => "CHECK_ENTRATO"
            16 => "CHECK_USCITO"
            17 => "PAGATO"
            18 => "PAGATO_DATA"
            19 => "IP_CREA"
            20 => "DATA_CREA"
            21 => "PERC_COMM"*/

            if($i == 0){
                $i++;
                continue;
            }

            $data = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]);
            $date_start = $data->format('Y-m-d');

            $data = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]);
            $date_end = $data->format('Y-m-d');

            $time = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]);
            $time_start = $time->format("H:i");

            $time = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]);
            $time_end= $time->format("H:i");

            $type_park = $row[1];

            $name = ucwords(trim(strtolower($row[6])));
            $mobile = trim($row[7]);
            $email = trim($row[8]);
            $number_flight = trim($row[9]);
            $number_partecipants = trim($row[10]);
            $targa = trim($row[11]);
            $number_days = trim($row[12]);
            $total = (float) trim($row[13]);
            $ip = trim($row[19]);

            $data = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[20]);
            $created_at = $data->format('Y-m-d');

            $is_payed = $row[17];

            $date_payed = null;
            if($is_payed == true){
                $data = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[20]);
                $date_payed = $data->format('Y-m-d');
            }


            PluginParkingReservation::insert([
               "name" => $name,
               "email" => $email,
               "mobile" => $mobile,
               "number_flight" => $number_flight,
               "number_partecipants" => $number_partecipants,
               "targa" => $targa,
               "number_days" => $number_days,
               "total" => $total,
               "ip" => $ip,
               "created_at" => $created_at,
               "is_payed" => $is_payed,
               "date_payed" => $date_payed,
               "date_start" => $date_start,
               "time_start" => $time_start,
               "date_end" => $date_end,
               "time_end" => $time_end,
               "type_park" => $type_park
            ]);

            echo "$name \n";

        }
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
