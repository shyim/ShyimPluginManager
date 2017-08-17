//{namespace name=backend/plugin_manager/translation}

//{block name="backend/plugin_manager/view/list/composer_page"}
Ext.define('Shopware.apps.PluginManager.view.list.ComposerPage', {
    extend: 'Shopware.grid.Panel',
    alias: 'widget.plugin-manager-composer-page',
    cls: 'plugin-manager-local-plugin-listing',

    mixins: {
        events: 'Shopware.apps.PluginManager.view.PluginHelper'
    },
    viewConfig: {
        markDirty: false
    },

    configure: function() {
        var me = this;

        return {
            addButton: false,
            pageSizeCombo: false,
            deleteButton: false,
            deleteColumn: false,
            editColumn: false,
            columns: {
                description: {
                    flex: 2,
                    header: '{s name="plugin_name"}Plugin name{/s}',
                    groupable: false,
                    editor: null,
                    renderer: me.descriptionRenderer
                },
                version: {
                    width: 160,
                    header: '{s name="version"}Version{/s}',
                    groupable: false,
                    editor: null
                },
                license: {
                    flex: 2,
                    sortable: false,
                    groupable: false,
                    cls: 'licence-column',
                    header: '{s name="licence"}License{/s}',
                    renderer: this.licenceRenderer,
                    editor: null
                },
                authors: {
                    header: '{s name="from_producer"}Developed by{/s}',
                    groupable: false,
                    renderer: this.authorRenderer,
                    editor: null
                }
            }
        };
    },

    initComponent: function() {
        var me = this;

        me.store = Ext.create('Shopware.apps.PluginManager.store.Composer');

        me.callParent(arguments);
    },

    createActionColumn: function () {
        var me = this;

        var actionColumn = me.callParent(arguments);

        actionColumn.width = 120;
        return actionColumn;
    },

    createSelectionModel: function() { },

    createFeatures: function() {
        var me = this,
            items = me.callParent(arguments);

        me.groupingFeature = Ext.create('Ext.grid.feature.Grouping', {
            groupHeaderTpl: new Ext.XTemplate(
                '{literal}{name:this.formatName} ({rows.length} Plugins){/literal}',
                {
                    formatName: function(name) {
                        switch(name) {
                            case 2:
                                return '{s name="group_headline_installed"}Installed{/s}';
                            case 1:
                                return '{s name="group_headline_deactivated"}Inactive{/s}';
                            case 0:
                                return '{s name="group_headline_uninstalled"}Uninstalled{/s}';
                        }
                    }
                }
            )
        });

        items.push(me.groupingFeature);
        return items;
    },

    authorRenderer: function(value, metaData, record) {
        var newValue = '';
        if (value.length === 0) {
            newValue = record.get('name').split('/')[0];
        } else {
            Ext.iterate(value, function (value, key) {
                newValue = (key !== 0 ? newValue + ', ' : '') + value['name'];
            })
        }

        var website = record.get('homepage');

        if (!website) {
            website = record.get('repository');
        }

        if (website && website.length > 0) {
            return '<a href="' + website + '" target="_blank">'+newValue+'</a>'
        } else {
            return newValue;
        }
    },

    descriptionRenderer: function (value, metaData, record) {
        if (value.length === 0) {
            return record.get('name');
        }

        return value;
    },

    licenceRenderer: function(value) {
        var result = '';

        if (value.length === 0) {
            return '';
        }

        Ext.iterate(value, function (itemValue, key) {
            result = (key !== 0 ? result + ', ' : '') + value;
        });

        return result;
    },

    dateRenderer: function(value) {
        if (!value || !value.hasOwnProperty('date')) {
            return value;
        }
        var date = this.formatDate(value.date);
        return Ext.util.Format.date(date);
    },

    createActionColumnItems: function() {
        var me = this, items = [];

        items.push({
            iconCls: 'sprite-pencil',
            tooltip: '{s name="open"}Open{/s}',
            handler: function(grid, rowIndex, colIndex, item, eOpts, record) {
                // me.displayPluginEvent(record);
            },
            getClass: function(value, metaData, record) {
                if (record.get('state') === 0) {
                    return Ext.baseCSSPrefix + 'hidden';
                }
            }
        });

        items.push({
            iconCls: 'sprite-plus-circle',
            tooltip: '{s name="install"}Install{/s}',
            handler: function(grid, rowIndex, colIndex, item, eOpts, record) {
                Ext.Ajax.request({
                    url: '{url controller=Composer action=install}',
                    params: {
                        plugin: record.get('name'),
                        version: record.get('version'),
                        installName: record.get('installName')
                    },
                    success: function(response){
                        var text = response.responseText;
                        var obj = JSON.parse(text);

                        me.installPluginEvent(Ext.create('Shopware.apps.PluginManager.model.Plugin', obj.data));
                    }
                });
            },
            getClass: function(value, metaData, record) {
                if (record.get('state') !== 0) {
                    return Ext.baseCSSPrefix + 'hidden';
                }
            }
        });

        items.push({
            iconCls: 'sprite-arrow-continue',
            tooltip: '{s name="reinstall"}Reinstall{/s}',
            handler: function(grid, rowIndex, colIndex, item, eOpts, record) {
                me.reinstallPluginEvent(record);
            },
            getClass: function(value, metaData, record) {
                if (record.get('state') === 0) {
                    return Ext.baseCSSPrefix + 'hidden';
                }
            }
        });

        items.push({
            iconCls: 'sprite-arrow-circle-135',
            tooltip: '{s name="update_plugin"}Update{/s}',
            handler: function(grid, rowIndex, colIndex, item, eOpts, record) {
                me.updatePluginEvent(record);
            },
            getClass: function(value, metaData, record) {
                if (record.get('version') === record.get('currentVersion') || record.get('state') === 0) {
                    return Ext.baseCSSPrefix + 'hidden';
                }
                this.items[3].tooltip = '{s name="install_update"}Install update{/s} (v ' + record.get('version') + ')';
            }
        });

        items.push({
            iconCls: 'sprite-bin-metal-full',
            tooltip: '{s name="delete"}Delete{/s}',
            handler: function(grid, rowIndex, colIndex, item, eOpts, record) {
                me.deletePluginEvent(record);
            },
            getClass: function(value, metaData, record) {
                if (record.get('state') !== 0) {
                    return Ext.baseCSSPrefix + 'hidden';
                }
            }
        });

        return items;
    },

    createToolbarItems: function() {
        return [];
    }
});
//{/block}