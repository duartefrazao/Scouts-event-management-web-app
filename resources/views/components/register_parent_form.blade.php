    <div class="container initial-page-container parent-form-container">
        <form enctype="multipart/form-data" method="POST" class="p-4 register_parent_form form_image" action="/registerParent" id="register">
        {{ csrf_field() }}
        <div> Registo do Encarregado de Educação </div>
        @component('components.register_form_basic_info')
        @endcomponent
        <a class="back-button"  href="start/#toregister"> Voltar </a>
        </form>
    </div>
</div>
    @include('components.image_crop')
</div>
