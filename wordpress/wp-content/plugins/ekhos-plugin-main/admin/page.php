<?php

function ekhos_ids_settings_page()
{
    ?>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('navigation', {
                active: '',

                init() {
                    const hash = window.location.hash;
                    if(hash) {
                        this.active = hash;
                    }
                },

                isActive(e) {
                    return this.active === e.getAttribute('href');
                },

                pageActive(e) {
                    return this.active === "#" + e.getAttribute('id');
                },

                setActive(e) {
                  this.active = e.target.getAttribute('href');
                  this.fetchData();
                },

                fetchData() {
                    Alpine.store('character_base').getItems();
                    Alpine.store('sound_base').getItems();
                    Alpine.store('linked_base').getItems();
                },
            });
        });
    </script>

    <div id="idsbody"
         x-data="{display: false}"
         x-init="display=true"
         style="display: none;"
         x-bind:style="display ? 'display: flex;' : 'display: none;'"
    >
        <?php
        include_once "pages/header.php";
        include_once "pages/about.php";
        include_once "pages/linked.php";
        include_once "pages/character.php";
        include_once "pages/sound.php";
        include_once "pages/settings.php";
        ?>
    </div>
    <?php
}
