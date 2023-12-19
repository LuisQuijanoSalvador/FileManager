<?php

namespace App\Http\Livewire;

use App\Models\Boleto;
use App\Models\Cliente;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class FacturacionTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Boleto>
     */
    public function datasource(): Builder
    {
        return Boleto::query()
                    ->join('clientes', function ($clientes) { 
                        $clientes->on('boletos.idCliente', '=', 'clientes.id');
                    })
                    ->select([
                        'boletos.*',
                        'clientes.razonSocial as razonSocial',
                    ]);
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('numeroBoleto')

           /** Example of custom column using a closure **/
            ->addColumn('numeroBoleto_lower', fn (Boleto $model) => strtolower(e($model->numeroBoleto)))

            ->addColumn('numeroFile')
            ->addColumn('idCliente')
            ->addColumn('fechaEmision_formatted', fn (Boleto $model) => Carbon::parse($model->fechaEmision)->format('d/m/Y'))
            ->addColumn('idCounter')
            ->addColumn('idTipoFacturacion')
            ->addColumn('idTipoDocumento')
            ->addColumn('idArea')
            ->addColumn('idVendedor')
            ->addColumn('idConsolidador')
            ->addColumn('codigoReserva')
            ->addColumn('fechaReserva_formatted', fn (Boleto $model) => Carbon::parse($model->fechaReserva)->format('d/m/Y'))
            ->addColumn('idGds')
            ->addColumn('idTipoTicket')
            ->addColumn('tipoRuta')
            ->addColumn('tipoTarifa')
            ->addColumn('idAerolinea')
            ->addColumn('origen')
            ->addColumn('pasajero')
            ->addColumn('idTipoPasajero')
            ->addColumn('ruta')
            ->addColumn('destino')
            ->addColumn('idDocumento')
            ->addColumn('tipoCambio')
            ->addColumn('idMoneda')
            ->addColumn('tarifaNeta')
            ->addColumn('inafecto')
            ->addColumn('igv')
            ->addColumn('otrosImpuestos')
            ->addColumn('xm')
            ->addColumn('total')
            ->addColumn('totalOrigen')
            ->addColumn('porcentajeComision')
            ->addColumn('montoComision')
            ->addColumn('descuentoCorporativo')
            ->addColumn('codigoDescCorp')
            ->addColumn('tarifaNormal')
            ->addColumn('tarifaAlta')
            ->addColumn('tarifaBaja')
            ->addColumn('idTipoPagoConsolidador')
            ->addColumn('centroCosto')
            ->addColumn('cod1')
            ->addColumn('cod2')
            ->addColumn('cod3')
            ->addColumn('cod4')
            ->addColumn('observaciones')
            ->addColumn('estado')
            ->addColumn('usuarioCreacion')
            ->addColumn('usuarioModificacion')
            ->addColumn('created_at_formatted', fn (Boleto $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
      * PowerGrid Columns.
      *
      * @return array<int, Column>
      */
    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('NumeroBoleto', 'numeroBoleto')
                ->sortable()
                ->searchable(),

            Column::make('NumeroFile', 'numeroFile')
                ->sortable()
                ->searchable(),

            Column::make('IdCliente', 'idCliente'),
            Column::make(__('Cliente'), 'razonSocial', 'clientes.razonSocial')->sortable()->searchable(),
            Column::make('FechaEmision', 'fechaEmision_formatted', 'fechaEmision')
                ->sortable(),

            Column::make('IdCounter', 'idCounter'),
            Column::make('IdTipoFacturacion', 'idTipoFacturacion'),
            Column::make('IdTipoDocumento', 'idTipoDocumento'),
            Column::make('IdArea', 'idArea'),
            Column::make('IdVendedor', 'idVendedor'),
            Column::make('IdConsolidador', 'idConsolidador'),
            Column::make('CodigoReserva', 'codigoReserva')
                ->sortable()
                ->searchable(),

            Column::make('FechaReserva', 'fechaReserva_formatted', 'fechaReserva')
                ->sortable(),

            Column::make('IdGds', 'idGds'),
            Column::make('IdTipoTicket', 'idTipoTicket'),
            Column::make('TipoRuta', 'tipoRuta')
                ->sortable()
                ->searchable(),

            Column::make('TipoTarifa', 'tipoTarifa')
                ->sortable()
                ->searchable(),

            Column::make('IdAerolinea', 'idAerolinea'),
            Column::make('Origen', 'origen')
                ->sortable()
                ->searchable(),

            Column::make('Pasajero', 'pasajero')
                ->sortable()
                ->searchable(),

            Column::make('IdTipoPasajero', 'idTipoPasajero')
                ->sortable()
                ->searchable(),

            Column::make('Ruta', 'ruta')
                ->sortable()
                ->searchable(),

            Column::make('Destino', 'destino')
                ->sortable()
                ->searchable(),

            Column::make('IdDocumento', 'idDocumento'),
            Column::make('TipoCambio', 'tipoCambio')
                ->sortable()
                ->searchable(),

            Column::make('IdMoneda', 'idMoneda'),
            Column::make('TarifaNeta', 'tarifaNeta')
                ->sortable()
                ->searchable(),

            Column::make('Inafecto', 'inafecto')
                ->sortable()
                ->searchable(),

            Column::make('Igv', 'igv')
                ->sortable()
                ->searchable(),

            Column::make('OtrosImpuestos', 'otrosImpuestos')
                ->sortable()
                ->searchable(),

            Column::make('Xm', 'xm')
                ->sortable()
                ->searchable(),

            Column::make('Total', 'total')
                ->sortable()
                ->searchable(),

            Column::make('TotalOrigen', 'totalOrigen')
                ->sortable()
                ->searchable(),

            Column::make('PorcentajeComision', 'porcentajeComision')
                ->sortable()
                ->searchable(),

            Column::make('MontoComision', 'montoComision')
                ->sortable()
                ->searchable(),

            Column::make('DescuentoCorporativo', 'descuentoCorporativo')
                ->sortable()
                ->searchable(),

            Column::make('CodigoDescCorp', 'codigoDescCorp')
                ->sortable()
                ->searchable(),

            Column::make('TarifaNormal', 'tarifaNormal')
                ->sortable()
                ->searchable(),

            Column::make('TarifaAlta', 'tarifaAlta')
                ->sortable()
                ->searchable(),

            Column::make('TarifaBaja', 'tarifaBaja')
                ->sortable()
                ->searchable(),

            Column::make('IdTipoPagoConsolidador', 'idTipoPagoConsolidador'),
            Column::make('CentroCosto', 'centroCosto')
                ->sortable()
                ->searchable(),

            Column::make('Cod1', 'cod1')
                ->sortable()
                ->searchable(),

            Column::make('Cod2', 'cod2')
                ->sortable()
                ->searchable(),

            Column::make('Cod3', 'cod3')
                ->sortable()
                ->searchable(),

            Column::make('Cod4', 'cod4')
                ->sortable()
                ->searchable(),

            Column::make('Observaciones', 'observaciones')
                ->sortable()
                ->searchable(),

            Column::make('Estado', 'estado'),
            Column::make('UsuarioCreacion', 'usuarioCreacion'),
            Column::make('UsuarioModificacion', 'usuarioModificacion'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [
            Filter::inputText('numeroBoleto')->operators(['contains']),
            Filter::inputText('numeroFile')->operators(['contains']),
            Filter::datepicker('fechaEmision'),
            Filter::inputText('codigoReserva')->operators(['contains']),
            Filter::datepicker('fechaReserva'),
            Filter::inputText('tipoRuta')->operators(['contains']),
            Filter::inputText('tipoTarifa')->operators(['contains']),
            Filter::inputText('origen')->operators(['contains']),
            Filter::inputText('pasajero')->operators(['contains']),
            Filter::inputText('idTipoPasajero')->operators(['contains']),
            Filter::inputText('ruta')->operators(['contains']),
            Filter::inputText('destino')->operators(['contains']),
            Filter::inputText('codigoDescCorp')->operators(['contains']),
            Filter::inputText('centroCosto')->operators(['contains']),
            Filter::inputText('cod1')->operators(['contains']),
            Filter::inputText('cod2')->operators(['contains']),
            Filter::inputText('cod3')->operators(['contains']),
            Filter::inputText('cod4')->operators(['contains']),
            Filter::inputText('observaciones')->operators(['contains']),
            Filter::datetimepicker('created_at'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Boleto Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('boleto.edit', function(\App\Models\Boleto $model) {
                    return $model->id;
               }),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('boleto.destroy', function(\App\Models\Boleto $model) {
                    return $model->id;
               })
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Boleto Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($boleto) => $boleto->id === 1)
                ->hide(),
        ];
    }
    */
}
