<!-- Modal -->
<script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">
<div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title add-image-modal-title">Adicionar imagem</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="column cropper-elems">
						<div class="col-md-4 text-center">
								<div id="upload-demo"></div>
						</div>
						<div class="col-md-4" style="padding-top:30px;">
							<div class="image-modal-footer">
								<div>
										<label for="upload">
											<strong> Selecionar imagem </strong>
										</label>	
									
								</div>
								<div>
										<button class="btn btn-secondary dismiss_btn" data-dismiss="modal">Cancelar</button>
										<button class="btn btn-success upload-result upload_btn" data-dismiss="modal">Upload</button>
								</div>
							</div>
								
						</div>
				
				
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
let cropppedImg=null;

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});


$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'circle'
    },
    boundary: {
        width: 300,
        height: 300
    }
});


$('#upload').on('change', function () { 
	var reader = new FileReader();
    reader.onload = function (e) {
		$('#upload').attr('src', e.target.result);
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
    	}).then(function(){
    		console.log('jQuery bind complete');
    	});
    }
    reader.readAsDataURL(this.files[0]);
});


$('.upload-result').on('click', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
		cropppedImg = resp;
		let span = document.querySelector(".member-face-registration");
				
		demo ='<img src="' + resp + '" data-toggle="modal" data-target="#uploadImageModal" id="select-image-btn"/>'
		span.innerHTML = demo;
		
	});
	
});


let file_input = document.querySelector("#upload");
let image = document.querySelector(".cr-image");

let upload_btn =  document.querySelector(".upload_btn");
upload_btn.addEventListener("click",function(e){
	
});

let dismiss_btn = document.querySelector(".dismiss_btn");
dismiss_btn.addEventListener("click",function(e){

	file_input.value = ''
	image.parentNode.removeChild(image);

});



let form_image = document.querySelector(".form_image");
form_image.addEventListener('submit',function(e){
	e.preventDefault();
	var input = $("<input class='input_hidden'>")
			   .attr("name", "cropped").val(cropppedImg);
			
	$('.form_image').append(input);
	
});

</script>
