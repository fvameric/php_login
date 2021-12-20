<div class="side-orden">
    <div class="lista-orden">
        <form method="POST" action="">
            <button type="submit" name="sort" value="1">Precio</button>
            <button type="submit" name="sort" value="2">Nombre</button>
            <?php if (isset($_SESSION['userSession']) && $contadorDeseados > 0) { ?>
                <button type="submit" name="sort" value="3">Deseados</button>
            <?php } ?>
        </form>
    </div>
</div>

<div class="side-categorias">
    <form method="GET" action="" class="botones-menu">
        <button type="submit" name="categoria" class="button" value="1">Aeonium</button>
        <button type="submit" name="categoria" class="button" value="2">Cotyledon</button>
        <button type="submit" name="categoria" class="button" value="3">Crassula</button>
        <button type="submit" name="categoria" class="button" value="4">Echeveria</button>
        <button type="submit" name="categoria" class="button" value="5">Euphorbia</button>
        <button type="submit" name="categoria" class="button" value="6">Haworthia</button>
        <button type="submit" name="categoria" class="button" value="7">Senecio</button>
    </form>
</div>