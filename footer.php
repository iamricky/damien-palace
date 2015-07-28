            <?php if(!is_single()):?>
                <footer>
                    <h1>Follow Damien</h1>
                    <?php wp_nav_menu( array( "theme_location" => "social", "container" => false ) ); ?>
                </footer>
            <?php endif; ?>

        <!-- Javcascript -->
        <?php wp_footer(); ?>
    </body>
</html>
