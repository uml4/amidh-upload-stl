(function() {
    tinymce.create('tinymce.plugins.wpLight3D', {
		init : function(ed, url) {
			ed.addButton('canvasioLightBtn',{
				class: 'media-views',
				title : 'Canvasio3D Light',
				image : url+'/canvasioLightBtn.png',
				onclick : function() {
					ed.execCommand('mceInsertContent', false, '[canvasio3D width="320" height="320" border="1" borderCol="#F6F6F6" dropShadow="0" backCol="#FFFFFF" backImg="..." mouse="on" rollMode="off" rollSpeedH="0" rollSpeedV="0" objPath="..." objScale="1.5" objColor="" lightSet="7" reflection="off" refVal="5" objShadow="off" floor="off" floorHeight="42" lightRotate="off" vector="off" mousewheel="on" Help="off"] [/canvasio3D]');
				}
			});
		},
		createControl : function(n, cm) {
		return null;
	}
    });
    tinymce.PluginManager.add('wpLight3D', tinymce.plugins.wpLight3D);
})();