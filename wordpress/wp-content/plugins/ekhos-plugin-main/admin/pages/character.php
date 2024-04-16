<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('character_base', {
            url: '/wp-json/ekhos/character/',
            items: [],
            sounds: [],
            isLoading: true,
            selected: {
                id: "null",
                name: "null",
                sound: "null"
            },

            init() {
                this.getItems();
            },

            updateSelected(id, name, sound) {
                this.selected = {
                    id: id ? id : 'null',
                    name: name ? name : 'null',
                    sound: sound ? sound : 'null'
                }
            },

            async request(endpoint, data) {
                let r = await fetch(`${this.url}${endpoint}`,
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    }
                );
                let d = await r.json();
                return d;
            },

            async getItems() {
                let r = await this.request('list', null);
                this.items = r.items;
                await this.getSounds();
                this.isLoading = false;
            },

            async getSounds() {
                let r = await this.request('sound-list', null);
                this.sounds = r.items;
            },
        });

        /* add character */
        Alpine.store('modal_new', {
            isLoading: false,
            name: '',
            sound: 'null',

            async request() {
                const character_base = Alpine.store('character_base');
                this.isLoading = true;
                const r = await character_base.request('add', {
                    name: this.name,
                    sound: this.sound
                });
                this.isLoading = false;
                character_base.getItems();
                document.querySelector(`#idscharacter_modal_new`).close();
                this.name = '';
                this.sound = 'null';
            },
        });

        /* update character */
        Alpine.store('modal_update', {
            isLoading: false,

            async request() {
                const character_base = Alpine.store('character_base');
                this.isLoading = true;
                const r = await character_base.request(`update/${character_base.selected.id}`, {
                    name: character_base.selected.name,
                    sound: character_base.selected.sound
                });
                this.isLoading = false;
                character_base.getItems();
                document.querySelector(`#idscharacter_modal_update`).close();
            },
        });

        /* delete character */
        Alpine.store('modal_delete', {
            isLoading: false,

            async request() {
                const character_base = Alpine.store('character_base');
                this.isLoading = true;
                const r = await character_base.request('delete', {
                    id: character_base.selected.id ? character_base.selected.id : ''
                });
                this.isLoading = false;
                character_base.getItems();
                document.querySelector(`#idscharacter_modal_delete`).close();
            },
        });

        /* update & delete audio */
        Alpine.store('modal_update_sound', {
            isLoading: false,
            sound: 'null',

            async request() {
                const character_base = Alpine.store('character_base');
                this.isLoading = true;
                const r = await character_base.request(`update/${character_base.selected.id}`, {
                    name: character_base.selected.name,
                    sound: this.sound
                });
                this.isLoading = false;
                character_base.getItems();
                document.querySelector(`#idscharacter_modal_add_audio`).close();
                document.querySelector(`#idscharacter_modal_delete_audio`).close();
                this.sound = 'null';
            },
        });
    });
</script>


<div x-data id="idscharacter"
     class="hidden"
     :class="{'hidden': !$store.navigation.pageActive($el)}">
    <div class="idscharacter_modals">
        <!-- NEW MODAL -->
        <dialog id="idscharacter_modal_new" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="container flex flex-col gap-3">
                    <h3 class="font-bold text-lg">Nouveau personnage</h3>
                    <label class="form-control w-full">
                        <span class="label-text pb-1">Nom du personnage :</span>
                        <input x-data type="text" placeholder="Nom" class="input input-bordered input-sm w-full"
                               x-model="$store.modal_new.name"/>
                    </label>
                    <label class="form-control w-full">
                        <span class="label-text pb-1">Son principal :</span>
                        <select x-data class="select select-bordered input-sm max-w-full-select"
                                x-model="$store.modal_new.sound">
                            <option disabled value="null">Aucun</option>
                            <template x-data x-for="(item, index) in $store.character_base.sounds" :key="index">
                                <option x-bind:value="item.id" x-text="item.name"></option>
                            </template>
                        </select>
                    </label>
                    <button x-data class="btn btn-primary mt-2 gap-0"
                            x-on:click="$store.modal_new.request()">
                        <span x-data class="loading loading-spinner hidden"
                              :class="{ 'hidden': !$store.modal_new.isLoading }"></span>
                        <span x-data :class="{ 'hidden': $store.modal_new.isLoading }">Ajouter un personnage</span>
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        <!-- UPDATE MODAL -->
        <dialog id="idscharacter_modal_update" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="container flex flex-col gap-3">
                    <h3 class="font-bold text-lg">Modifier le personnage</h3>
                    <label class="form-control w-full">
                        <span class="label-text pb-1">Nom du personnage :</span>
                        <input x-data type="text" placeholder="Nom" class="input input-bordered input-sm w-full"
                               x-model="$store.character_base.selected.name"/>
                    </label>
                    <label class="form-control w-full">
                        <span class="label-text pb-1">Son principal :</span>
                        <select x-data class="select select-bordered input-sm max-w-full-select"
                                x-model="$store.character_base.selected.sound">
                            <option disabled value="null">Aucun</option>
                            <template x-data x-for="(item, index) in $store.character_base.sounds" :key="index">
                                <option x-bind:value="item.id" x-text="item.name"></option>
                            </template>
                        </select>
                    </label>
                    <button x-data class="btn btn-info mt-2 gap-0"
                            x-on:click="$store.modal_update.request()">
                        <span x-data class="loading loading-spinner hidden"
                              :class="{ 'hidden': !$store.modal_update.isLoading }"></span>
                        <span x-data
                              :class="{ 'hidden': $store.modal_update.isLoading }">Modifier le personnage n°
                            <b x-data x-text="$store.character_base.selected.id">null</b>
                        </span>
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        <!-- DELETE MODAL -->
        <dialog id="idscharacter_modal_delete" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="container flex flex-col gap-3">
                    <h3 class="font-bold text-lg">Supprimer le personnage</h3>
                    <p>Êtes-vous sûr de vouloir supprimer le personange n°
                        <b x-data x-text="$store.character_base.selected.id"></b>
                        (<b x-data x-text="$store.character_base.selected.name">null</b>)
                    </p>
                    <button x-data class="btn btn-error mt-2 gap-0"
                            x-on:click="$store.modal_delete.request()">
                        <span x-data class="loading loading-spinner hidden"
                              :class="{ 'hidden': !$store.modal_delete.isLoading }"></span>
                        <span x-data :class="{ 'hidden': $store.modal_delete.isLoading }">Supprimer le personnage n°
                            <b x-data x-text="$store.character_base.selected.id">null</b>
                        </span>
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        <!-- ADD AUDIO MODAL -->
        <dialog id="idscharacter_modal_add_audio" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="container flex flex-col gap-3">
                    <h3 class="font-bold text-lg">Lier un son</h3>
                    <select x-data x-model="$store.modal_update_sound.sound"
                            class="select select-bordered input-sm max-w-full-select">
                        <option disabled value="null">Aucun</option>
                        <template x-data x-for="(item, index) in $store.character_base.sounds" :key="index">
                            <option x-bind:value="item.id" x-text="item.name"></option>
                        </template>
                    </select>
                    <button x-data class="btn btn-info mt-2 gap-0"
                            x-on:click="$store.modal_update_sound.request()">
                        <span x-data class="loading loading-spinner hidden"
                              :class="{ 'hidden': !$store.modal_update_sound.isLoading }"></span>
                        <span x-data :class="{ 'hidden': $store.modal_update_sound.isLoading }">Lier un son</span>
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        <!-- DELETE AUDIO MODAL -->
        <dialog id="idscharacter_modal_delete_audio" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="container flex flex-col gap-3">
                    <h3 class="font-bold text-lg">Supprimer la liaison de ce son ?</h3>
                    <button x-data class="btn btn-error mt-2 gap-0"
                            x-on:click="$store.modal_update_sound.request()">
                        <span x-data class="loading loading-spinner hidden"
                              :class="{ 'hidden': !$store.modal_update_sound.isLoading }"></span>
                        <span x-data :class="{ 'hidden': $store.modal_update_sound.isLoading }">Supprimer ce son</span>
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </div>

    <div class="idscharacter_new my-8">
        <button x-data class="btn btn-primary" onclick="idscharacter_modal_new.showModal()"
                x-on:click="$store.modal_new.isLoading = false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg"
                 viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
            </svg>
            Ajouter un personnage
        </button>
    </div>
    <div class="overflow-x-auto">
        <div x-data class="skeleton h-12 w-full"
             :class="{ 'hidden': !$store.character_base.isLoading }"></div>
        <table x-data class="table border hidden" :class="{ 'hidden': $store.character_base.isLoading }">
            <!-- head -->
            <thead class="bg-base-100 text-base-content text-lg">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Son principal</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <!-- row -->
            <template x-data x-for="(item, index) in $store.character_base.items" :key="index">
                <tr :class="index % 2 == 0 ? 'bg-gray-300' : 'bg-gray-200'">
                    <!-- ID -->
                    <th x-text="item.id"></th>
                    <!-- NAME -->
                    <td x-text="item.name"></td>
                    <!-- AUDIO -->
                    <td class="flex items-center gap-2">
                        <audio controls :src="item.sound_url" :class="{'hidden': !item.sound_url}"></audio>
                        <!-- delete button -->
                        <button class="btn btn-circle btn-neutral"
                                :class="{'hidden': !item.sound_url}"
                                onclick="idscharacter_modal_delete_audio.showModal()"
                                @click="$store.character_base.updateSelected(
                                item.id, item.name, 'null')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                            </svg>
                        </button>
                        <!-- add button -->
                        <button class="btn btn-circle btn-neutral"
                                :class="{'hidden': item.sound_url}"
                                onclick="idscharacter_modal_add_audio.showModal()"
                                @click="$store.character_base.updateSelected(
                                item.id, item.name, item.sound_id)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                        </button>
                    </td>
                    <!-- ACTIONS -->
                    <td class="lex items-center gap-2">
                        <!-- ACTIONS - edit -->
                        <button class="btn btn-circle btn-neutral" onclick="idscharacter_modal_update.showModal()"
                                @click="$store.character_base.updateSelected(
                                item.id, item.name, item.sound_id)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                        </button>
                        <!-- ACTIONS - delete -->
                        <button class="btn btn-circle btn-neutral" onclick="idscharacter_modal_delete.showModal()"
                                @click="$store.character_base.updateSelected(
                                item.id, item.name, item.sound_id)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</div>