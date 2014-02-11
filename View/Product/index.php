<?php use Library\Utils; ?>

<h1>Liste des produits</h1>

<table class="table table-hover">

    <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Date ajout</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($products_list as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td>
                    <a href="<?php echo Utils::makeURL('product.show', array(Utils::slugify($product['name']), $product['id'])); ?>">
                        <?php echo Utils::secureHTML($product['name']); ?>
                    </a>
                </td>
                <td><?php echo $product['price']; ?> &euro;</td>
                <td><?php echo $product['date_created']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>