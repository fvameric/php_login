<div class="lista-orden">
    <form method="POST" action="">
        <button type="submit" name="sort" class="button" value="1">Ordenar por precio</button>
        <button type="submit" name="sort" class="button" value="2">Ordenar por nombre</button>
        <?php if (isset($_SESSION['userSession']) && $contadorDeseados > 0) { ?>
            <button type="submit" name="sort" class="button" value="3">Ordenar por deseados</button>
        <?php } ?>
    </form>
</div>