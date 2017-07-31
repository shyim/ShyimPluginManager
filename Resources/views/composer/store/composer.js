//{block name="backend/plugin_manager/store/composer"}
Ext.define('Shopware.apps.PluginManager.store.Composer', {
    extend:'Shopware.store.Listing',

    pageSize: 20000,
    autoLoad: true,
    remoteSort: false,
    remoteFilter: false,

    groupers: [{
        property: 'state',
        direction: 'DESC'
    }],

    configure: function() {
        return {
            controller: 'PluginManager',
            proxy: {
                type: 'ajax',
                api: {
                    read: '{url controller=Composer action=list}'
                },
                reader: {
                    type: 'json',
                    root: 'data',
                    totalProperty: 'total'
                }
            }
        };
    },

    sorters: [ {
        property: 'name',
        direction: 'ASC'
    } ],

    model: 'Shopware.apps.PluginManager.model.Composer'
});
//{/block}