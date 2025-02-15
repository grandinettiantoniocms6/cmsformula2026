<div class="container">
    <div class="row icon-5xl text-center">
        <form method="GET" action="results">
           {{ csrf_field() }}
           <input type="text" name="s" value="" placeholder="Cerca nel sito">
           <button class="btn btn-primary" type="submit">Cerca</button>
        </form>
    </div>
</div>
