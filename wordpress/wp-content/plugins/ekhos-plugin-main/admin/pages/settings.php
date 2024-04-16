<div id="idssettings"
     x-data id="idslinked"
     class="hidden"
     :class="{'hidden': !$store.navigation.pageActive($el)}">

    <div class="idssettings_items bg-base-100 mt-8 w-fit p-4 rounded flex flex-col gap-2">
        <div class="flex gap-2 items-center">
            <span class="whitespace-nowrap">Menu activé :</span>
            <input type="checkbox" class="checkbox input-xs" id="activated">
        </div>
        <div class="flex gap-2 items-center">
            <span class="whitespace-nowrap">Choisir l’état par défaut du menu utilisateur :</span>
            <select id="state" class="select select-bordered input-xs"></select>
        </div>
        <div class="flex gap-2 items-center">
            <span class="whitespace-nowrap">Choisir l’apparition du menu utilisateur :</span>
            <select id="appearance" class="select select-bordered input-xs"></select>
        </div>
        <div class="flex gap-2 items-center">
            <span class="whitespace-nowrap">Couleur de fond :</span>
            <input type="color" id="background" class="input input-bordered input-xs">
        </div>
        <div class="flex gap-2 items-center">
            <span class="whitespace-nowrap">Couleur des boutons :</span>
            <input type="color" id="buttons" class="input input-bordered input-xs">
        </div>
        <div class="flex gap-2 items-center">
            <span class="whitespace-nowrap">Couleur du texte :</span>
            <input type="color" id="text" class="input input-bordered input-xs">
        </div>
        <div class="flex gap-2 items-center">
            <span class="whitespace-nowrap">Couleur des bordures :</span>
            <input type="color" id="border" class="input input-bordered input-xs">
        </div>
        <div class="flex gap-2 items-center">
            <span class="whitespace-nowrap">Sons au survol du menu utilisateur :</span>
            <input type="file" id="hover" class="file-input w-full file-input-bordered file-input-xs">
        </div>
        <div class="flex gap-2 items-center">
            <span class="whitespace-nowrap">Sons au clic du menu utilisateur :</span>
            <input type="file" id="click" class="file-input w-full file-input-bordered file-input-xs">
        </div>
    </div>
</div>