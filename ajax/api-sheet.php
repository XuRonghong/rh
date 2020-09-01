<?php
    $column=json_encode(getColumName($tablename),JSON_UNESCAPED_UNICODE);
?>
<div class="sheet" style="padding:20px">
    <ul class="sheet-list" style="padding:0;list-style:none">
        <li class="sheet-item" style="padding:5px 0">
        <input type="text" size="30">
            <select>
                <option value="VARCHAR">VARCHAR</option>
                <option value="TEXT">TEXT</option>
                <option value="INT">INT</option>
                <option value="DATE">DATE</option>
                <option value="DATETIME">DATETIME</option>
            </select>
            <input type="text" size="10" placeholder="長度" value="">
            <input type="text" size="10" placeholder="預設值" value="NULL">
            <span class="sheet-delete">刪除</span>
        </li>
    </ul>
    <button class="sheet-submit" type="button"> 建立欄位 </button>
</div>
<script>
    $(document).ready(function(){
        var $input=$('#edit_form input[name],#edit_form textarea[name],#edit_form select[name]');
        var $list=$('.sheet-list');
        var $item=$('.sheet-item').clone().end().remove();
        var $delete=$item.find('.sheet-delete');
        var tablename='<?php echo $tablename?>';
        var column=JSON.parse('<?php echo $column?>'||'[]')
        var field={
            length:{
                '1':['state','state'],
                '2':['month'],
                '4':['sortnum','year','hour'],
                '8':['price','money','amount','fee','point','class'],
                '20':['tel','phone','mobile','idno'],
                '40':['id'],
                '100':['name','title','img','address','email'],
                '200':['file']
            },
            type:{
                'TEXT':['content','memo'],
                'INT':['state','sortstate','sortnum','price','unit','amount','year','month','hour','fee','point'],
                'DATE':['date']
            }
        }
            
        $delete.click(function(){
            $(this).parent().remove();
        })
        $item.append($delete);

        $('.sheet-submit').click(function(){
            var postdata=[];

            $('.sheet-item').each(function(){
                var $this=$(this);
                postdata.push({
                    name:$this.find('input').eq(0).val(),
                    type:$this.find('select').val(),
                    length:$this.find('input').eq(1).val(),
                    default:$this.find('input').eq(2).val(),
                })
            })

            $.post('./../api-sheet-create.php', {
                tablename: tablename,
                postdata: postdata
            }, function(data, textStatus, xhr) {
                console.log(data)
                var json=JSON.parse(data||'[]');
                for(var i=0,imax=json.length;i<imax;i++){
                    $list.append('<li>'+json[i]+'</li>')
                }
                /*optional stuff to do after success */
            });
        })
        
        // remove custom field
        column.push('backurl');
        column.push('backediturl');

        // init
        $input.each(function(){
            var $tmpitem=$item.clone(true);
            var name=$(this).attr('name');
            if(column.indexOf(name)<0){
                $tmpitem.find('input').eq(0).val(name);
                for(var i in field.length){
                    for(var j in field.length[i]){
                        if(name.search(field.length[i][j])>=0){
                            $tmpitem.find('input').eq(1).val(i);
                            break;
                        }
                    }
                }
                for(var i in field.type){
                    for(var j in field.type[i]){
                        if(name.search(field.type[i][j])>=0){
                            $tmpitem.find('option[value="'+i+'"]').prop('selected',true);
                            break;
                        }
                    }
                }
                $list.append($tmpitem);
            }
        })

    })
</script>