<aside class="col-md-4 border">
    <div class="p-4 mb-3 bg-light rounded">
        <?php
        if ($cfg->isKnowledgebaseEnabled()
        && ($faqs = FAQ::getFeatured()->select_related('category')->limit(5))
        && $faqs->all()) { ?>
            <h4 class="font-italic"><?php echo __('Featured Questions'); ?></h4>
            <ol class="list-unstyled mb-0">
            <?php   foreach ($faqs as $F) { ?>
                    <li><a href="<?php echo ROOT_PATH; ?>kb/faq.php?id=<?php
                    echo urlencode($F->getId());
                    ?>"><?php echo $F->getLocalQuestion(); ?></a></li>
            <?php   } ?>
            </ol>
        <?php
        } ?>
    </div>
    <div class="p-4">
        <?php
        $resources = Page::getActivePages()->filter(array('type'=>'other'));
        if ($resources->all()) { ?>
            <h4 class="font-italic"><?php echo __('Other Resources'); ?></h4>
            <ol class="list-unstyled mb-0">
            <?php   foreach ($resources as $page) { ?>
                <li><a href="<?php echo ROOT_PATH; ?>pages/<?php echo $page->getNameAsSlug();
                ?>"><?php echo $page->getLocalName(); ?></a></li>
            <?php   } ?>
            </ol>
        <?php
        }
        ?>
    </div>
</aside>

