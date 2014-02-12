<?php use Library\Utils; ?>

<h1 class="home-title">Bienvenue sur eCom.fr</h1>

<?php for ($i = 0; $i <= count($products_list); $i++): ?>

    <div class="row">

        <?php for ($j = 0; $j <= 3 && isset($products_list[$i+$j]); $j++): ?>

            <?php
            $product = $products_list[$i+$j];
            ?>

            <div class="col-sm-4">

                <div class="thumbnail">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo Utils::secure($product['name']); ?>">
                    <div class="caption">
                        <h4><?php echo Utils::secure($product['name']); ?></h4>
                        <p><?php echo nl2br(Utils::secure($product['description'])); ?></p>
                        <p>
                            <a href="<?php echo Utils::generateUrl('frontend.product.show', array(Utils::slugify($product['name']), $product['id'])); ?>" class="btn btn-primary" role="button" title="Afficher détails">
                                <span class="glyphicon glyphicon-eye-open"></span> Voir
                            </a> 
                            <a href="<?php echo Utils::generateUrl('frontend.cart.add', array(Utils::slugify($product['name']), $product['id'])); ?>" class="btn btn-default" role="button" title="Ajouter au panier">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                            </a>
                        </p>
                    </div>
                </div>

            </div>

        <?php endfor; ?>

    </div>

    <?php $i += 3; ?>

<?php endfor; ?>