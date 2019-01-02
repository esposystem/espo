/**
 * etree - jQuery EasyUI
 * 
 * Licensed under the GPL:
 */
(function($){
	function createTree(target){
		var opts = $.data(target, 'etree').options;
		
		$(target).tree($.extend({}, opts, {
			onDblClick: function(node){
				$(this).tree('beginEdit', node.target);
			},
			
			onBeforeEdit: function(node){
				
				if (opts.onBeforeEdit.call(target, node) == false) return false;
				$(this).tree('disableDnd');
			},
			onAfterEdit: function(node){
			
				var nodeParent = $(this).tree('getParent', node.target);
	
				if(nodeParent)
					var parentId = nodeParent.id;
				else
					var parentId = 0;
				
				//console.log(parentId);
									
					$.ajax({
						url: opts.updateUrl,
						type: 'post',
						dataType: 'json',
						data: {
							id: node.id,
							text: node.text,
							parentId: parentId,
							checked : node.checked
						},
						success: function(result){
							
							if (!result.success){
								$.messager.show({   // show error message  
								    title: 'Error',  
								    msg: result.msg  
								});  
							}
						}
					});
					$(this).tree('enableDnd');
					opts.onAfterEdit.call(target, node);
			},
		
		
		
		
		
			onCancelEdit: function(node){
				$(this).tree('enableDnd');
				opts.onCancelEdit.call(target, node);
			},
			onDrop: function(targetNode, source, point){
				var targetId = $(target).tree('getNode', targetNode).id;
			//	var parentId = $(target).tree('getParent', targetNode).id;
				
				var nodeParent = $(target).tree('getParent', targetNode);
		
				if(point == "append")
					parentId = targetId;
				else{	
					if(nodeParent){
					
						var parentId = ( parseInt(nodeParent.id) );
					}
					else
						var parentId = 1;
						
				}
				//console.log("targetId "+targetId);
				//console.log('parent'+parentId);
				
				$.ajax({
					url: opts.dndUrl,
					type: 'post',
					dataType: 'json',
					data: {
						id: source.id,
						targetId: targetId,
						point: point,
						parentId: parentId
					}
				});
				opts.onDrop.call(target, targetNode, source, point);
			}
		}));
	}
	
	$.fn.etree = function(options, param){
		if (typeof options == 'string'){
			var method = $.fn.etree.methods[options];
			if (method){
				return method(this, param);
			} else {
				return this.tree(options, param);
			}
		}
		
		options = options || {};
		return this.each(function(){
			var state = $.data(this, 'etree');
			if (state){
				$.extend(state.options, options);
			} else {
				$.data(this, 'etree', {
					options: $.extend({}, $.fn.etree.defaults, $.fn.etree.parseOptions(this), options)
				});
			}
			createTree(this);
		});
	};
	
	$.fn.etree.methods = {
		options: function(jq){
			return $.data(jq[0], 'etree').options;
		},
		
		operaciones: function(jq){
			return jq.each(function(){
				
			var opts = $.data(this, 'etree').options;

			var nodesChecked = $(this).tree('getChecked');
			 
			var stroper = new Array();
			 
			var rowcount = nodesChecked.length;
			for(var i=0; i<rowcount; i++){
				console.log(nodesChecked[i]);
			
				if(nodesChecked[i].id.indexOf('_') == 1)
						stroper.push(nodesChecked[i].id);
			}
			
		//	console.log(stroper);
			
			$.ajax({
					url: opts.updateUrlOper,
					type: 'post',
					dataType: 'json',
					data: {
					//	id: node.id,
						isopr : stroper.join(),
					//	text: node.text,
					//	checked : node.checked,
					//	parentId: parentId,
						
					}
					
		
			});
		});
		},
		
		modulo: function(jq){
			return jq.each(function(){
				
			var tree = $(this);
			var node = tree.tree('getSelected');
			
			$('#wrap2').show();
			$('form#submit').show();
			$('#IDModulo').attr('value',node.id);
				
				//alert(node.id);
			});
		},
		create: function(jq){
			return jq.each(function(){
				var opts = $.data(this, 'etree').options;
				var tree = $(this);
				var node = tree.tree('getSelected');
				
					$.ajax({
						url: opts.createUrl,
						type: 'post',
						dataType: 'json',
						data: {
							parentId: (node ? node.id : 0)
						},
						success: function(data){
						//	console.log('jeje');
							tree.tree('append', {
								parent: (node ? node.target : null),
								data: [data]
							});
						}
					});
			
			});
		},
	
		destroy: function(jq){
			return jq.each(function(){
				var opts = $.data(this, 'etree').options;
				var tree = $(this);
				var node = tree.tree('getSelected');
				if (node){
					$.messager.confirm(opts.destroyMsg.confirm.title,opts.destroyMsg.confirm.msg, function(r){
						if (r){
						
							if (opts.destroyUrl){
								
								$.post(opts.destroyUrl, {id:node.id}, function(result){
									
									if (result.success){
										tree.tree('remove', node.target);
									} else {
										$.messager.show({   // show error message  
										    title: 'Error',  
										    msg: result.msg  
										});  
									}
									
								},'json');
							} else {
							//	tree.tree('remove', node.target);
							//	console.log(result);
							}
						}
					});
				} else {
					$.messager.show({
						title:opts.destroyMsg.norecord.title,
						msg:opts.destroyMsg.norecord.msg
					});
				}
			});
		}
	};
	
	$.fn.etree.parseOptions = function(target){
		var t = $(target);
		return $.extend({}, $.fn.tree.parseOptions(target), {
			createUrl: (t.attr('createUrl') ? t.attr('createUrl') : undefined),
			updateUrl: (t.attr('updateUrl') ? t.attr('updateUrl') : undefined),
			destroyUrl: (t.attr('destroyUrl') ? t.attr('destroyUrl') : undefined),
			dndUrl: (t.attr('dndUrl') ? t.attr('dndUrl') : undefined),
			updateUrlOper: (t.attr('updateUrlOper') ? t.attr('updateUrl') : undefined)

		});
	};
	
	$.fn.etree.defaults = $.extend({}, $.fn.tree.defaults, {
		editMsg:{
			norecord:{
				title:'Atenci&oacute;n',
				msg:'Debe seleccionar un nodo.'
			}
		},
		destroyMsg:{
			norecord:{
				title:'Atenci&oacute;n',
				msg:'Debe seleccionar un nodo.'
			},
			confirm:{
				title:'Confirmar',
				msg:'Esta seguro que desea eliminar este nodo ?'
			}
		},
	
		dnd:true,
		url:null,	// return tree data
		createUrl:null,	// post parentId, return the created node data{id,text,...}
		updateUrl:null,	// post id,text, return updated node data.
		destroyUrl:null,	// post id, return {success:true}
		dndUrl:null,	// post id,targetId,point, return {success:true}
		updateUrlOper:null
	});
	
	
})(jQuery);