<ul class="nav navbar-nav">

    <?php foreach ($this->app['config']['menu'] as $title => $data):
        if (!isset($data['role']) || @$this->app['session']->hasRole($data['role'])):
        
            $active = ($data['url'] == $this->app['request']->requestUri()) ? 'active ' : '';

            if (isset($data['sub'])): ?>
                <li class="<?php echo $active; ?>dropdown">
                    <a href="<?php echo $data['url']; ?>" class="dropdown-toggle" data-toggle="dropdown">
                        <?php echo $title; ?> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <?php foreach ($data['sub'] as $title_sub => $data_sub): ?>

                            <?php if ($title_sub == 'divider'): ?>
                                <li class="divider"></li>
                            <?php else: ?>
                                <li><a href="<?php echo $data_sub['url']; ?>"><?php echo $title_sub; ?></a></li>
                            <?php endif; ?>
                            
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php else: ?>
                <li class="<?php echo $active; ?>">
                    <a href="<?php echo $data['url']; ?>">
                        <?php echo $title; ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>

    <?php endforeach; ?>

</ul>