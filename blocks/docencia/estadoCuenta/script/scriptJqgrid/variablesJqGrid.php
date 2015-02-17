<?php
//Estas variables se colocan para permitir que se pueda realizar una edición de datos locales
//con formularios en jqgrid 
?>
<script type='text/javascript'>
	var grid=$("<?php echo $nombreTabla?>"),
	
	getColumnIndex = function (columnName) {
        var cm = $(this).jqGrid('getGridParam', 'colModel'), i, l = cm.length;
        for (i = 0; i < l; i++) {
            if ((cm[i].index || cm[i].name) === columnName) {
                return i; // return the colModel index
            }
        }
        return -1;
    },
	
	 onclickSubmitLocal = function (options, postdata) {

    	$resultado=$("#FrmGrid_gridElementos").validationEngine('validate');

    	if(!$resultado){
    		options.processing = true;
    		return false;
        }

		console.log(postdata);	
		//SARA: Se modifica el arreglo postdata para intercambiar datos
        
        var intermediario;
        intermediario=postdata["marca"];
        postdata["marca"]=postdata["idMarca"];
        postdata["idMarca"]=intermediario;
        
        intermediario=postdata["iva"];
        postdata["iva"]=postdata["idIva"];
        postdata["idIva"]=intermediario;


   	 
        var $this = $(this), grid_p = this.p,
            idname = grid_p.prmNames.id,
            grid_id = this.id,
            id_in_postdata = grid_id + "_id",
            rowid = postdata[id_in_postdata],
            addMode = rowid === "_empty",
            oldValueOfSortColumn,
            new_id,
            tr_par_id,
            colModel = grid_p.colModel,
            cmName,
            iCol,
            cm;

        // postdata has row id property with another name. we fix it:
        if (addMode) {
            // generate new id
            new_id = $.jgrid.randId();
            while ($("#" + new_id).length !== 0) {
                new_id = $.jgrid.randId();
            }
            postdata[idname] = String(new_id);
        } else if (typeof postdata[idname] === "undefined") {
            // set id property only if the property not exist
            postdata[idname] = rowid;
        }
        delete postdata[id_in_postdata];

        // prepare postdata for tree grid
        if (grid_p.treeGrid === true) {
            if (addMode) {
                tr_par_id = grid_p.treeGridModel === 'adjacency' ? grid_p.treeReader.parent_id_field : 'parent_id';
                postdata[tr_par_id] = grid_p.selrow;
            }

            $.each(grid_p.treeReader, function (i) {
                if (postdata.hasOwnProperty(this)) {
                    delete postdata[this];
                }
            });
        }

        // decode data if there encoded with autoencode
        if (grid_p.autoencode) {
            $.each(postdata, function (n, v) {
                postdata[n] = $.jgrid.htmlDecode(v); // TODO: some columns could be skipped
            });
        }

        // save old value from the sorted column
        oldValueOfSortColumn = grid_p.sortname === "" ? undefined : grid.jqGrid('getCell', rowid, grid_p.sortname);

        // save the data in the grid
        if (grid_p.treeGrid === true) {
            if (addMode) {
                $this.jqGrid("addChildNode", new_id, grid_p.selrow, postdata);
            } else {
                $this.jqGrid("setTreeRow", rowid, postdata);
            }
        } else {
            if (addMode) {
                // we need unformat all date fields before calling of addRowData
                for (cmName in postdata) {
                    if (postdata.hasOwnProperty(cmName)) {
                        iCol = getColumnIndex.call(this, cmName);
                        if (iCol >= 0) {
                            cm = colModel[iCol];
                            if (cm && cm.formatter === "date") {
                                postdata[cmName] = $.unformat.date.call(this, postdata[cmName], cm);
                            }
                        }
                    }
                }                
                //console.log(postdata);
                $this.jqGrid("addRowData", new_id, postdata, options.addedrow);
                
            } else {
                $this.jqGrid("setRowData", rowid, postdata);
            }

            //Calcular totales
            //Recorrer todas las filas
            
            var miGrilla=$("<?php echo $nombreTabla?>");
            var filas = jQuery(miGrilla).getDataIDs();
            var valorTotal=0;
			for(a=0;a<filas.length;a++)
			 {
			    row=jQuery(miGrilla).getRowData(filas[a]);
			    console.log(row);
			    valorTotal=valorTotal+ parseFloat(row.precio); 
			
			 };
            
            $('.ui-jqgrid-sdiv').find('td[aria-describedby="gridElementos_elemento"]').text(valorTotal.toString());



            
        }

        if ((addMode && options.closeAfterAdd) || (!addMode && options.closeAfterEdit)) {
            // close the edit/add dialog
            $.jgrid.hideModal("#editmod" + grid_id, {
                gb: "#gbox_" + grid_id,
                jqm: options.jqModal,
                onClose: options.onClose
            });
        }

        if (postdata[grid_p.sortname] !== oldValueOfSortColumn) {
            // if the data are changed in the column by which are currently sorted
            // we need resort the grid
            setTimeout(function () {
                $this.trigger("reloadGrid", [{current: true}]);
            }, 100);
        }

        // !!! the most important step: skip ajax request to the server
        options.processing = true;
        return {};
    }, 
    
    editSettings = {
            //recreateForm: true,
            //jqModal: false,
            width:600,
            reloadAfterSubmit: false,
            closeOnEscape: true,
            //savekey: [true, 13],
            closeAfterEdit: true,
            onclickSubmit: onclickSubmitLocal,
            beforeShowForm: function (formid) { 
            	//alert($('#idElemento').val());
            	$(formid).validationEngine('hide'); 
            	$(formid).validationEngine({promptPosition : 'centerRight'});
            }            
          
        },
        addSettings = {
            recreateForm: true,
            //jqModal: false,
            reloadAfterSubmit: false,
            width:600,
            //savekey: [true, 13],
            closeOnEscape: true,
            closeAfterAdd: true,
            onclickSubmit: onclickSubmitLocal,
            beforeShowForm: function (formid) { $(formid).validationEngine('hide'); $(formid).validationEngine({promptPosition : 'centerRight'});}
        },

        delSettings = {
                // because I use "local" data I don't want to send the changes to the server
                // so I use "processing:true" setting and delete the row manually in onclickSubmit
                onclickSubmit: function(options, rowid) {
                	var grid=$("<?php echo $nombreTabla?>");
                    var grid_id = $.jgrid.jqID(grid[0].id),
                        grid_p = grid[0].p,
                        newPage = grid[0].p.page;
                    // delete the row
                    grid.delRowData(rowid);
                    $.jgrid.hideModal("#delmod"+grid_id,
                                      {gb:"#gbox_"+grid_id,jqm:options.jqModal,onClose:options.onClose});

                    if (grid_p.lastpage > 1) {// on the multipage grid reload the grid
                        if (grid_p.reccount === 0 && newPage === grid_p.lastpage) {
                            // if after deliting there are no rows on the current page
                            // which is the last page of the grid
                            newPage--; // go to the previous page
                        }
                        // reload grid to make the row from the next page visable.
                        grid.trigger("reloadGrid", [{page:newPage}]);
                    }

                    return true;
                },
                processing:true
            }
</script>     