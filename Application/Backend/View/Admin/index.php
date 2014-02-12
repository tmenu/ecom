<?php use Library\Utils ?>
<h2>
    Administration
</h2>

<ul>
    <li><a href="<?php echo Utils::generateUrl('backend.product.index'); ?>">Produits</a></li>
    <li><a href="<?php echo Utils::generateUrl('backend.client.index'); ?>">Clients</a></li>
</ul>