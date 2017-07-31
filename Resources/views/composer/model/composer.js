//{block name="backend/plugin_manager/model/composer"}
Ext.define('Shopware.apps.PluginManager.model.Composer', {
    extend: 'Shopware.data.Model',

    configure: function () {
        return {
            controller: 'PluginManager'
        };
    },

    fields: [
        { name: 'name', type: 'string' },
        { name: 'description', type: 'string' },
        { name: 'url', type: 'string' },
        { name: 'repository', type: 'string' },
        { name: 'downloads', type: 'string' },
        { name: 'favers', type: 'string' },
        { name: 'version', type: 'string' },
        { name: 'authors', type: 'auto' },
        { name: 'homepage', type: 'string' },
        { name: 'installName', type: 'string' },
        { name: 'license', type: 'auto' },
        { name: 'state', type: 'integer' }
    ]
});
//{/block}