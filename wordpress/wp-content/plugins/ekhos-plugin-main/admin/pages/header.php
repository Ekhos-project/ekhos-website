<div class="navbar bg-base-100 mt-4">
    <div class="flex-1">
        <a href="<?= admin_url('tools.php?page=ekhos-ids'); ?>" class="btn btn-ghost text-xl">
            <img class="h-4" src="<?= plugin_dir_url(__DIR__) ?>../assets/images/header_logo_plugin.png"
                 alt="ID SOUND">
        </a>
    </div>
    <div class="flex-none">
        <ul class="menu menu-horizontal px-1 gap-2">
            <li>
                <a x-data href="#idscharacter" class="px-2"
                   :class="{'active': $store.navigation.isActive($el)}"
                   @click="$store.navigation.setActive($event)">
                    Personnages
                </a>
            </li>
            <li>
                <a x-data href="#idssound" class="px-2"
                   :class="{'active': $store.navigation.isActive($el)}"
                   @click="$store.navigation.setActive($event)">
                    Sons
                </a>
            </li>
            <li>
                <a x-data href="#idslinked" class="px-2"
                   :class="{'active': $store.navigation.isActive($el)}"
                   @click="$store.navigation.setActive($event)">
                    Lier des sons
                </a>
            </li>
<!--            <li>-->
<!--                <a x-data href="#idssettings" class="px-2"-->
<!--                   :class="{'active': $store.navigation.isActive($el)}"-->
<!--                   @click="$store.navigation.setActive($event)">-->
<!--                    Paramètres-->
<!--                </a>-->
<!--            </li>-->
        </ul>
    </div>
</div>
