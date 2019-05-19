<form action="search" method="GET" >
    <input type="hidden" name="resource" value="users">
    
    <input type="hidden" name="query" value="{{$query}}">
    
    <div class="form-row d-flex ">
        <div class="form-group col-md-auto">
            <label for="age-input">Idade</label>
            <input name="age" type="number" class="form-control" id="age-input" placeholder="Idade">
        </div>
        <div class="form-group col-md-auto">
            <label for="input-section"> Secção </label>
            <select id="input-section" class="form-control" name="section">
                <option value="" selected>Escolhe a secção </option>
                <option value="1"> Lobitos </option>
                <option value="2"> Exploradores </option>
                <option value="3"> Pioneiros </option>
                <option value="4"> Caminheiros </option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary search-button">Pesquisar</button>
    </div>
</form>