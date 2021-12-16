<div class="side-orden">
    <div class="lista-orden">
        <form method="POST" action="">
            <button type="submit" name="sort" value="1">Ordenar por precio</button>
            <button type="submit" name="sort" value="2">Ordenar por nombre</button>
            <?php if (isset($_SESSION['userSession']) && $contadorDeseados > 0) { ?>
                <button type="submit" name="sort" value="3">Ordenar por deseados</button>
            <?php } ?>
        </form>
    </div>
</div>

<div class="side-categorias">
    <form method="GET" action="" class="botones-menu">
        <div class="caja1">
            <button type="submit" name="categoria" class="button" value="1">Aeonium</button>
        </div>
        <div class="caja2">
            <button type="submit" name="categoria" class="button" value="2">Cotyledon</button>
        </div>
        <div class="caja3">
            <button type="submit" name="categoria" class="button" value="3">Crassula</button>
        </div>
        <div class="caja4">
            <button type="submit" name="categoria" class="button" value="4">Echeveria</button>
        </div>
        <div class="caja5">
            <button type="submit" name="categoria" class="button" value="5">Euphorbia</button>
        </div>
        <div class="caja6">
            <button type="submit" name="categoria" class="button" value="6">Haworthia</button>
        </div>
        <div class="caja7">
            <button type="submit" name="categoria" class="button" value="7">Senecio</button>
        </div>
    </form>
</div>