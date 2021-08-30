<div id="tree">
    @foreach ($menus as $menu)
        @if( count($menu->childs) )
            <li><span class="caret"></span><span class="dblclick" data-id="{{ $menu->id }}"><i class="far fa-folder"></i> {{ $menu->name }}</span>
                @include('menus.admin-treeChild',[ 'childs' => $menu->childs ])
            </li>
        @else
            <li class="dblclick" data-id="{{ $menu->id }}"><i class="far fa-file"></i> {{ $menu->name }}</li>
        @endif
    @endforeach
</div>


<script type="text/javascript">

    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
        //console.log('getElementsByClassName toggler ',i);

        toggler[i].addEventListener("click", function(e) {
            //console.log('click toggler ',i);

            e.preventDefault();
            e.stopPropagation();

            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
            $(this).find('i').toggleClass('fa-folder-open fa-folder');
        });
    }


    var dblclickElem = document.getElementsByClassName("dblclick");
    for (i = 0; i < dblclickElem.length; i++) {
        //console.log('getElementsByClassName dblclick ',i);

        dblclickElem[i].addEventListener("dblclick", function(e) {
            e.preventDefault();
            e.stopPropagation();

            var menu_id = $(this).data('id');
            //console.log('dblclick',menu_id);

            axios.post('/menus/edit' ,{
                params: {
                    menu_id: menu_id
                }
            })
            .then((response) => {
                //console.log(response);
                var menu = response.data;
                $("#menu_id").val(menu.id);
                $("#menu_name").val(menu.name);
                $("#menu_url").val(menu.url);
                $("#menu_parent_id").val(menu.parent_id);
                if(menu.enabled == 1){
                    $('#menu_enabledLbl').text("Si");
                    $('#menu_enabled').prop('checked', true);
                } else{
                    $('#menu_enabledLbl').text("No");
                    $('#menu_enabled').prop('checked', false);
                }

                $("#btnSaveMenu").html("<i class='far fa-save'></i> Actualizar");

            }).catch((error)=>{
                console.log('error:',error);
                toastr.error('ERROR: ' + error);
            });

        });
    }

    $( '.caret' ).toggleClass('caret-down');
    $( '.caret' ).find('i').toggleClass('fa-folder-open fa-folder');
    $( '.nested' ).toggleClass('active');

</script>
