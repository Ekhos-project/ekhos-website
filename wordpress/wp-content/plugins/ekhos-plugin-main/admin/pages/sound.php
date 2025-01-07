<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('sound_base', {
            url: '/wp-json/ekhos/sound/',
            items: [],
            characters: [],
            isLoading: true,
            selected: {
                id: "null",
                name: "null",
                character: "null"
            },

            init() {
                this.getItems();
            },

            updateSelected(id, name, character) {
                this.selected = {
                    id: id ? id : 'null',
                    name: name ? name : 'null',
                    character: character ? character : 'null'
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
                await this.getCharacters();
                this.isLoading = false;
            },

            async getCharacters() {
                let r = await this.request('character-list', null);
                this.characters = r.items;
            },
        });

        /* add sound */
        Alpine.store('sound_modal_new', {
            isLoading: false,
            name: '',
            character: 'null',

            async request(e) {
                const sound_base = Alpine.store('sound_base');
                const formData = new FormData();
                const file_field = e.parentNode.querySelector("#idssound_audio_file");
                this.isLoading = true;

                if (file_field.files.length) {
                    const file = file_field.files[0];
                    formData.append('file', file);
                }
                formData.append('name', this.name);
                formData.append('character', this.character);

                let r = await fetch(`${sound_base.url}add`,
                    {
                        method: 'POST',
                        body: formData
                    }
                );
                let d = await r.json();

                this.isLoading = false;
                sound_base.getItems();
                file_field.value = '';
                document.querySelector(`#idssound_modal_new`).close();
                this.name = '';
                this.character = 'null';
            },
        });

        /* update sound */
        Alpine.store('sound_modal_update', {
            isLoading: false,

            async request(e) {
                const sound_base = Alpine.store('sound_base');
                const formData = new FormData();
                const file_field = e.parentNode.querySelector("#idssound_audio_file_update");
                this.isLoading = true;

                if (file_field.files.length) {
                    const file = file_field.files[0];
                    formData.append('file', file);
                }
                formData.append('name', sound_base.selected.name);
                formData.append('character', sound_base.selected.character);

                let r = await fetch(`${sound_base.url}update/${sound_base.selected.id}`,
                    {
                        method: 'POST',
                        body: formData
                    }
                );
                let d = await r.json();

                this.isLoading = false;
                file_field.value = '';
                sound_base.getItems();
                document.querySelector(`#idssound_modal_update`).close();
            },
        });

        /* delete sound */
        Alpine.store('sound_modal_delete', {
            isLoading: false,

            async request() {
                const sound_base = Alpine.store('sound_base');
                this.isLoading = true;
                const r = await sound_base.request('delete', {
                    id: sound_base.selected.id ? sound_base.selected.id : ''
                });
                this.isLoading = false;
                sound_base.getItems();
                document.querySelector(`#idssound_modal_delete`).close();
            },
        });
    });
</script>


<div x-data id="idssound"
     class="hidden"
     :class="{'hidden': !$store.navigation.pageActive($el)}">

    <div class="idssound_modals">
        <!-- NEW MODAL -->
        <dialog id="idssound_modal_new" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="container flex flex-col gap-3">
                    <h3 class="font-bold text-lg">Nouveau son</h3>
                    <label class="form-control w-full">
                        <span class="label-text pb-1">Nom du son :</span>
                        <input x-data type="text" placeholder="Nom" class="input input-bordered input-sm w-full"
                               x-model="$store.sound_modal_new.name"/>
                    </label>
                    <label class="form-control w-full">
                        <span class="label-text pb-1">Personnage :</span>
                        <select x-data class="select select-bordered input-sm max-w-full-select"
                                x-model="$store.sound_modal_new.character">
                            <option disabled value="null">Aucun</option>
                            <template x-data x-for="(item, index) in $store.sound_base.characters" :key="index">
                                <option x-bind:value="item.id" x-text="item.name"></option>
                            </template>
                        </select>
                    </label>
                    <label class="form-control w-full">
                        <span class="label-text pb-1">Fichier audio :</span>
                        <input id="idssound_audio_file" type="file"  accept="audio/*" class="file-input file-input-bordered file-input-sm w-full" />
                    </label>
                    <button x-data class="btn btn-primary mt-2 gap-0"
                            x-on:click="$store.sound_modal_new.request($el)">
                        <span x-data class="loading loading-spinner hidden"
                              :class="{ 'hidden': !$store.sound_modal_new.isLoading }"></span>
                        <span x-data :class="{ 'hidden': $store.sound_modal_new.isLoading }">Ajouter un son</span>
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        <!-- DELETE MODAL -->
        <dialog id="idssound_modal_delete" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="container flex flex-col gap-3">
                    <h3 class="font-bold text-lg">Supprimer le son</h3>
                    <p>Êtes-vous sûr de vouloir supprimer le son n°
                        <b x-data x-text="$store.sound_base.selected.id"></b>
                        (<b x-data x-text="$store.sound_base.selected.name">null</b>)
                    </p>
                    <button x-data class="btn btn-error mt-2 gap-0"
                            x-on:click="$store.sound_modal_delete.request()">
                        <span x-data class="loading loading-spinner hidden"
                              :class="{ 'hidden': !$store.sound_modal_delete.isLoading }"></span>
                        <span x-data :class="{ 'hidden': $store.sound_modal_delete.isLoading }">Supprimer le son n°
                            <b x-data x-text="$store.sound_base.selected.id">null</b>
                        </span>
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>

        <!-- UPDATE MODAL -->
        <dialog id="idssound_modal_update" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <div class="container flex flex-col gap-3">
                    <h3 class="font-bold text-lg">Modifier le son</h3>
                    <label class="form-control w-full">
                        <span class="label-text pb-1">Nom du son :</span>
                        <input x-data type="text" placeholder="Nom" class="input input-bordered input-sm w-full"
                               x-model="$store.sound_base.selected.name"/>
                    </label>
                    <label class="form-control w-full">
                        <span class="label-text pb-1">Personnage :</span>
                        <select x-data class="select select-bordered input-sm max-w-full-select"
                                x-model="$store.sound_base.selected.character">
                            <option disabled value="null">Aucun</option>
                            <template x-data x-for="(item, index) in $store.sound_base.characters" :key="index">
                                <option x-bind:value="item.id" x-text="item.name"></option>
                            </template>
                        </select>
                    </label>
                    <label class="form-control w-full">
                        <span class="label-text pb-1">Fichier audio :</span>
                        <input id="idssound_audio_file_update" type="file"  accept="audio/*" class="file-input file-input-bordered file-input-sm w-full" />
                    </label>
                    <button x-data class="btn btn-info mt-2 gap-0"
                            x-on:click="$store.sound_modal_update.request($el)">
                        <span x-data class="loading loading-spinner hidden"
                              :class="{ 'hidden': !$store.sound_modal_update.isLoading }"></span>
                        <span x-data
                              :class="{ 'hidden': $store.sound_modal_update.isLoading }">Modifier le son n°
                            <b x-data x-text="$store.sound_base.selected.id">null</b>
                        </span>
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </div>

    <div class="idssound_new my-8">
        <button x-data class="btn btn-primary" onclick="idssound_modal_new.showModal()"
                x-on:click="$store.modal_new.isLoading = false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg"
                 viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
            </svg>
            Ajouter un son
        </button>
    </div>

    <div class="overflow-x-auto">
        <div x-data class="skeleton h-12 w-full"
             :class="{ 'hidden': !$store.sound_base.isLoading }"></div>
        <table x-data class="table border hidden" :class="{ 'hidden': $store.sound_base.isLoading }">
            <!-- head -->
            <thead class="bg-base-100 text-base-content text-lg">
            <tr>
                <th>ID</th>
                <th>Personnage</th>
                <th>Nom</th>
                <th>Audio</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <!-- row -->
            <template x-data x-for="(item, index) in $store.sound_base.items" :key="index">
                <tr :class="index % 2 == 0 ? 'bg-gray-300' : 'bg-gray-200'">
                    <!-- ID -->
                    <th x-text="item.id"></th>
                    <!-- CHARACTER -->
                    <td x-text="item.character_name"></td>
                    <!-- NAME -->
                    <td x-text="item.name"></td>
                    <!-- AUDIO -->
                    <td class="flex items-center gap-2">
                        <audio controls :src="item.sound_url" :class="{'hidden': !item.sound_url}"></audio>
                    </td>
                    <!-- ACTIONS -->
                    <td class="lex items-center gap-2">
                        <!-- ACTIONS - edit -->
                        <button class="btn btn-circle btn-neutral" onclick="idssound_modal_update.showModal()"
                                @click="$store.sound_base.updateSelected(
                                item.id, item.name, item.character_id)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                        </button>
                        <!-- ACTIONS - delete -->
                        <button class="btn btn-circle btn-neutral" onclick="idssound_modal_delete.showModal()"
                                @click="$store.sound_base.updateSelected(
                                item.id, item.name, item.character_id)">
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
