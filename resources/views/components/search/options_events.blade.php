<form action="search" method="GET">
    <input type="hidden" name="resource" value="events">
    <input type="hidden" name="query" value="{{$query}}">
    <div class=" form-row d-flex">
        <div class="form-group col-md-auto">
            <label for="begin-date">Data de início</label>
            <input name="start_date" type="date" class="form-control" id="begin-date">
        </div>
        <div class="form-group col-md-auto">
            <label for="end-date">Data de fim</label>
            <input name="end_date" type="date" class="form-control" id="end-date">
        </div>
        <div class="form-group col-md-auto">
            <label for="tag-input"> Tags </label>
            <select name="tag" id="tag-input" class="form-control">
                <option value="" selected>Escolha um tag: </option>
                <option value="XPTO"> XPTO </option>
                <option value="ACANAC"> ACANAK </option>
                <option value="Evento"> EVENT </option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary search-button">Pesquisar</button>
</form>