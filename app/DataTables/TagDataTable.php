<?php

namespace App\DataTables;

use App\Models\Tag;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TagDataTable extends DataTable
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
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" name="row_checkbox" data-id="'.$data->id.'">';
            })
            ->addColumn('action', function ($data) {
                return '
                    <button data-toggle="tooltip" data-placement="top" title="Edit" onClick="editRecord('.$data->id.')" id="edit-'.$data->id.'" edit-route="'.route('tags.edit', $data).'" class="btn btn-icon">
                        <i class="fas fa-pen text-info"></i>
                    </button>
                    <button data-toggle="tooltip" data-placement="top" title="Delete" onClick="deleteRecord('.$data->id.')" id="delete-'.$data->id.'" delete-route="'.route('tags.destroy', $data).'" class="btn btn-icon">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                ';
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['checkbox', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Tag $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Tag $model)
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
                    ->setTableId('tag-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(2, 'ASC');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('checkbox')->title('<input type="checkbox" name="main_checkbox" id="delete-all" title="checkbox">'),
            Column::make('DT_RowIndex')->searchable(false)->title('No')->width(50),
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
        return 'Tag_' . date('YmdHis');
    }
}
