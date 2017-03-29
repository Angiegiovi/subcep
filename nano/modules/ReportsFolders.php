<?xml version="1.0" encoding="UTF-8"?>
<root xmlns:vue='http://openbank.com/vue'>
<template>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <h2 id="nav-tabs">Carpetas</h2>
            <abmgroup
                id="ReportsFolders.Folders"
                vue:model="folder"
                groupField="folder_id"
                vue:root="null"
                typeField="type"
                nameField="name"
                leafType="LEAF"
                childrenAssociation="children" >
            </abmgroup>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8" v-show.visible="$root.getPaths().length > 1">
            <h2 id="nav-tabs">Reportes</h2>
            <abm
                id="ReportsFolders.Reports"
                vue:model="report"
                refreshWith="ReportsFolders.Folders"
                nameField="name">
                <chart refreshWith="ReportsFolders.Reports" vue:model="report"/>
            </abm>
        </div>
    </div>
</template>
<script>
    var module = new Module({
        "name": "ReportsFolders",
        "prefix": "be",
        "title": "Reportes y Folders",
        "icon": "fa fa-folder",
        "menu": "main/Reportes",
        "models": [
            new Module.Model({
                "name": "report",
                "fields": [
                    new Module.Model.Field({
                        "name": "name",
                        "type": "string",
                        "label": "Nombre",
                    }),
                    new Module.Model.Field({
                        "name": "variables",
                        "type": "string",
                        "list": false,
                        "label": "Variables",
                        "source": new Module.View.ModelInstance("ReportsFolders.Variable"),
                        "textField": "name",
                        "ui": "tags",
                    }),
                    new Module.Model.Field({
                        "name": "aggregator",
                        "type": "string",
                        "list": false,
                        "ui": "select",
                        "label": "Agregación",
                        "enum": ["sum", "max", "min", "avg"],
                    }),
                    /*new Module.Model.Field({
                        "name": "measure",
                        "type": "string",
                        "label": "Medida",
                        "list": false,
                        "default": "valor",
                        "source": function(){
                            return module.table.$selectFrom(
                                "columnas",
                                {"tabla":module.report.table}
                            );
                        },
                        "textField": "name",
                        "ui": "select",
                    }),*/
                    new Module.Model.Field({
                        "name": "rows",
                        "type": "string",
                        "list": false,
                        "label": "Filas",
                        "source": function(){
                            return module.dimension;
                        },
                        "textField": "name",
                        "ui": "tags",
                    }),
                    new Module.Model.Field({
                        "name": "cols",
                        "type": "string",
                        "list": false,
                        "label": "Columnas",
                        "source": function(){
                            return module.dimension;
                        },
                        "textField": "name",
                        "ui": "tags",
                    }),
                ],
                "associations": [
                    new Module.Model.BelongsTo({
                        "name": "folder",
                        "model": "folder"
                    }),
                    new Module.Model.HasMany({
                        "name": "variables",
                        "model": "variable"
                    })
                ],
                "methods": {
                    "dashboard1(t)": <?php
                        function dashboard1($t=0)
                        {
                            $res = ['x'=>[],'series'=>['reportes'=>[]]];
                            $rep = \DB::select("select (select be_folders.name from be_folders where be_folders.id=be_reports.folder_id) as name, count(*) as count from be_reports group by folder_id");
                            foreach ($rep as $row) {
                                $res['x'][] = $row->name;
                                $res['series']['reportes'][] = $row->count;
                            }
                            return $res;
                        }
                    ?>,
                    "tablas(conn)": <?php
                    function tablas($conn=null) {
                        $collection = [];
                        $tables = \DB::connection("datos")->getDoctrineSchemaManager()->listTableNames();
                        $type = 'tables';
                        foreach ($tables as $name) {
                            $collection[] = [
                                'type'          => $type,
                                'id'            => $name,
                                'attributes'    => ['name'=>$name],
                                'relationships' => [],
                            ];
                        }
                        return ['data'=>$collection];
                    }
                    ?>,
                    "columnas(tabla)": <?php
                    function columnas($tabla='ejemplo') {
                        $collection = [];
                        $columns = \DB::connection("datos")->getSchemaBuilder()->getColumnListing($tabla);
                        $type = 'columns';
                        foreach ($columns as $name) {
                            $collection[] = [
                                'type'          => $type,
                                'id'            => $name,
                                'attributes'    => ['name'=>$name],
                                'relationships' => [],
                            ];
                        }
                        return ['data'=>$collection];
                    }
                    ?>
                }
            }),
            new Module.Model({
                "name": "folder",
                "fields": [
                    new Module.Model.Field({
                        "name": "name",
                        "type": "string",
                        "label": "Nombre",
                    }),
                    new Module.Model.Field({
                        "name": "type",
                        "type": "string",
                        "default": "FOLDER",
                        "enum": ["FOLDER", "LEAF"],
                        "label": "Tipo",
                        "list": false,
                    }),
                ],
                "associations": [
                    new Module.Model.BelongsTo({
                        "name": "folder",
                        "model": "folder"
                    }),
                    new Module.Model.HasMany({
                        "name": "children",
                        "model": "folder"
                    }),
                    new Module.Model.HasMany({
                        "name": "reports",
                        "model": "report"
                    }),
                ]
            }),
            new Module.Model({
                "name": "variable_tag",
                "fields": [
                    new Module.Model.Field({
                        "name": "name",
                        "type": "string",
                        "label": "Nombre",
                    }),
                ],
                "associations": [
                ],
                methods:{
                    "tagsList()": <?php
                    function tagsList() {
                        $collection = [];
                        $list = $this->all();
                        $type = 'variable_tag';
                        foreach ($list as $row) {
                            $collection[] = [
                                'type'          => $type,
                                'id'            => $row->name,
                                'attributes'    => $row,
                                'relationships' => [],
                            ];
                        }
                        return ['data'=>$collection];
                    }
                    ?>
                }
            }),
            new Module.Model({
                "name": "variable",
                "fields": [
                    new Module.Model.Field({
                        "name": "name",
                        "label": "Nombre",
                        "type": "string",
                    }),
                    new Module.Model.Field({
                        "name": "tags",
                        "label": "Tipos",
                        "type": "string",
                        "ui": "tags",
                        "source": function(){
                            return module.variableTags.$selectFrom("tagsList", {});
                        },
                        "textField": "name",
                    }),
                    new Module.Model.Field({
                        "name": "description",
                        "label": "Descripción",
                        "type": "string",
                    }),
                ],
                "associations": [
                ],
            }),
            new Module.Model({
                "name": "unit",
                "fields": [
                    new Module.Model.Field({
                        "name": "name",
                        "type": "string"
                    }),
                ],
                "associations": [
                    new Module.Model.BelongsTo({
                        "name": "family",
                        "model": "family"
                    }),
                ]
            }),
            new Module.Model({
                "name": "family",
                "fields": [
                    new Module.Model.Field({
                        "name": "name",
                        "label": "Nombre",
                        "type": "string",
                    }),
                    new Module.Model.Field({
                        "name": "main_unit",
                        "label": "Unidad principal",
                        "type": "string"
                    }),
                ],
                "associations": [
                ]
            }),
            new Module.Model({
                "name": "dimension",
                "fields": [
                    new Module.Model.Field({
                        "name": "name",
                        "label": "Nombre",
                        "type": "string"
                    }),
                    new Module.Model.Field({
                        "name": "column",
                        "label": "Columna de la tabla",
                        "type": "string"
                    }),
                ],
                "associations": [
                    new Module.Model.HasMany({
                        "name": "domains",
                        "model": "domain"
                    }),
                ]
            }),
            new Module.Model({
                "name": "domain",
                "fields": [
                    new Module.Model.Field({
                        "name": "name",
                        "label": "Nombre",
                        "type": "string"
                    }),
                    new Module.Model.Field({
                        "name": "synonyms",
                        "label": "Sinónimos (separados por comas)",
                        "type": "string"
                    }),
                ],
                "associations": [
                    new Module.Model.BelongsTo({
                        "name": "dimension",
                        "model": "dimension"
                    }),
                ]
            }),
            new Module.Model({
                "name": "formula",
                "fields": [
                    new Module.Model.Field({
                        "name": "formula",
                        "label": "Fórmula y = f(x)",
                        "type": "string"
                    }),
                ],
                "associations": [
                    new Module.Model.BelongsTo({
                        "name": "origin",
                        "label": "Unidad origen (x)",
                        "list": true,
                        "form": true,
                        "textField": "name",
                        "ui": "select",
                        "source": new Module.View.ModelInstance("ReportsFolders.Unit"),
                        "model": "unit"
                    }),
                    new Module.Model.BelongsTo({
                        "name": "target",
                        "label": "Unidad destino (y)",
                        "list": true,
                        "form": true,
                        "textField": "name",
                        "ui": "select",
                        "source": new Module.View.ModelInstance("ReportsFolders.Unit"),
                        "model": "unit"
                    }),
                ]
            }),
        ],
        "views": {
        },
        "data": {
            report: new Module.View.ModelInstance("ReportsFolders.Report", "ReportsFolders/folders/{module.folder.id}/reports"),
            folder: new Module.View.ModelInstance("ReportsFolders.Folder"),
            //conexion: new Module.View.ModelInstance("Connections.Connection"),
            //table: new Module.View.ModelInstance("Connections.Co", "ReportsFolders/connections/{module.conexion.id}/tables"),
            table: new Module.View.ModelInstance("ReportsFolders.Report"),
            variableTags: new Module.View.ModelInstance("ReportsFolders.VariableTag"),
            dimension: new Module.View.ModelInstance("ReportsFolders.Dimension"),
        }
    });
</script>
</root>