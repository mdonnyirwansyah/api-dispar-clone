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
            ->addIndexColumn()
            ->addColumn('category', function ($data) {
                return $data->category->name;
            })
            ->addColumn('author', function ($data) {
                return $data->author['name'];
            })
            ->addColumn('editor', function ($data) {
                if ($data->editor_id) {
                    return $data->editor['name'];
                } else {
                    return '';
                }
            })
            ->addColumn('action', function ($data) {
                return '
                    <a data-toggle="tooltip" data-placement="top" title="Edit" href="'.route('news.posts.edit', $data).'" class="btn btn-icon">
                        <i class="fas fa-pen text-info"></i>
                    </a>
                    <button data-toggle="tooltip" data-placement="top" title="Delete" onClick="deleteRecord('.$data->id.')" id="delete-'.$data->id.'" delete-route="'.route('news.posts.destroy', $data).'" class="btn btn-icon">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                ';
            })
            ->editColumn('editor', function ($data) {
                if ($data->editor_id) {
                    return $data->editor['name'];
                } else {
                    return '-';
                }
            })
            ->editColumn('created_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('Y-m-d H:i:s');

                return $formatedDate;
            })
            ->editColumn('updated_at', function ($data) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->updated_at)->format('Y-m-d H:i:s');

                return $formatedDate;
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
            Column::computed('category'),
            Column::computed('author'),
            Column::computed('editor'),
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
