
<form enctype="multipart/form-data" method="POST" class="p-4 form_image" action="/register" id="register" >
        {{ csrf_field() }}

        <div class="btn-group btn-group-toggle user-type" data-toggle="buttons">
             {{--Used for sending always information--}}
             <input type="hidden" name="options" value="menor">

             <label class="btn btn-secondary active">
                 <input  type="radio" name="options" id="Escuteiro" autocomplete="off" value="menor"> Menor de idade
             </label>
             <label class="btn btn-secondary">
                 <input  type="radio" name="options" id="Encarregado" autocomplete="off" value="maior"> Maior de Idade
             </label>
        </div>
      
        @component('components.register_form_basic_info')
        @endcomponent
      </form>
      @include('components.session_message')
</div>


