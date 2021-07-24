<?php

namespace App\DataTables;

use App\Models\NewsTag;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NewsTagDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return '
                    <button data-toggle="tooltip" data-placement="top" title="Edit" onClick="editRecord('.$data->id.')" id="edit-'.$data->id.'" edit-route="'.route('news.tags.edit', $data).'" class="btn btn-icon">
                        <i class="fas fa-pen text-info"></i>
                    </button>
                    <button data-toggle="tooltip" data-placement="top" title="Delete" onClick="deleteRecord('.$data->id.')" id="delete-'.$data->id.'" delete-route="'.route('news.tags.destroy', $data).'" class="btn btn-icon">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                ';
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('Y-m-d H:i:s');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\NewsTag $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(NewsTag $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('newstag-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1, 'ASC');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->width(50),
            Column::make('name'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')->width(85)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'NewsTag_' . date('YmdHis');
    }
}
