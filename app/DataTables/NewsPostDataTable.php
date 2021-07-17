<?php

namespace App\DataTables;

use App\Models\NewsPost;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NewsPostDataTable extends DataTable
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
            ->removeColumn('id')
            ->setRowId(function ($data) {
                return 'row'.$data->id;
            })
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) { 
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('Y-m-d H:i:s'); 

                return $formatedDate; 
            })
            ->editColumn('updated_at', function ($data) { 
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('Y-m-d H:i:s'); 

                return $formatedDate; 
            })
            ->addColumn('action', function ($data) {
                return '
                    <a href="'.route('news.posts.edit', $data).'" class="btn btn-icon">
                        <i class="fas fa-pen text-info"></i>
                    </a> 
                    <button onClick="deleteRecord('.$data->id.')" id="record'.$data->id.'" data-route="'.route('news.posts.destroy', $data).'" class="btn btn-icon">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                ';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\NewsPost $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(NewsPost $model)
    {
        return $model->with('category', 'user');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('newspost-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(5);
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
            Column::make('title'),
            Column::make('category.name')->title('Category'),
            Column::make('user.name')->title('Author'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')->width(85),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'NewsPost_' . date('YmdHis');
    }
}
