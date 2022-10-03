<?php

namespace App\Imports;

use App\Models\Contacts\BaseRecord;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Row;

class ContactsImport implements OnEachRow, WithEvents
{
    use Importable;

    protected $project_id;
    protected $persistent;

    private $company_acc;
    private $result_acc;

    public function __construct(bool $persistent, ?int $project_id = null)
    {
        $this->persistent = $persistent;
        $this->project_id = $project_id;
    }

    public function onRow(Row $row): void
    {
        if (!$row[0]) {
            // Продолжение предыдущей записи
            if ($this->company_acc == null) {
                Log::warning("Company name missing");
                $this->company_acc = $this->newBaseRecord('', isset($row[3]) ? $row[3] : '');

            }
            $this->company_acc->phones .= "\n${row[1]}";
            $this->company_acc->names .= "\n${row[2]}";
            $this->company_acc->info .= "\n" . (isset($row[3]) ? $row[3] : '');
        } else {
            // Новая запись. Возвращаем старую если есть
            $this->yield();
            $this->company_acc = $this->newBaseRecord($row[0], isset($row[3]) ? $row[3] : '');
            $this->company_acc->phones = $row[1];
            $this->company_acc->names = $row[2];
        }
    }

    private function newBaseRecord(string $company, string $info): BaseRecord {
        $rec = new BaseRecord();
        if ($this->project_id !== null)
            $rec->project_id = $this->project_id;
        $rec->company = $company;
        $rec->info = $info;

        return $rec;
    }

    private function yield(): void {
        if (!$this->company_acc)
            return;

        $this->company_acc->info = trim($this->company_acc->info) or null;
        $this->result_acc[] = $this->company_acc;
        if ($this->persistent)
            $this->company_acc->save();
        $this->company_acc = null;
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $this->result_acc = [];
            },
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->company_acc = null;
            },
            AfterSheet::class => function(AfterSheet $event) {
                $this->yield();
            }
        ];
    }

    public function toModels(string $filename): array {
        $this->import($filename);
        return $this->result_acc;
    }
}
