<?php

$page_id = get_the_ID();
//echo '<div id="audio_sound-pageid" data-pageid="' . $page_id . '"></div>';
//echo '<div id="audio_sound-default" data-url="' . plugin_dir_url(__DIR__) . '/assets/images/default.mp3"></div>';

?>

<div id="idsound-public" x-data="idsoundmenu" >

    <style type="text/css">
        @font-face {
            font-family: "owners-wide";
            src: url(<?= plugin_dir_url(__DIR__) ?>/assets/fonts/owners-wide.ttf) format("truetype");
        }
    </style>

    <div class="idsound-public_action" @click="openMenu()">
        <div class="idsound-public_action_active hidden" :class="{ 'hidden': soundAllowed }"></div>
        <img src="<?= plugin_dir_url(__DIR__) ?>/assets/images/logo_idsound.png" alt="idsound_action">
    </div>

    <div class="idsound-public_menu" :class="{ 'active': menuOpen }">
        <div class="idsound-public_menu_content" :class="{ 'active': menuOpen }">
            <div class="idsound-public_menu_content_back" @click="closeMenu()">
                <span>Retour</span>
            </div>

            <div class="idsound-public_menu_content_title">
                <span>Je règle mon IdSound</span>
            </div>

            <div class="idsound-public_menu_content_voices">
                <div class="idsound-public_menu_content_voices_title">
                    <span>Qui m'accompagne ?</span>
                </div>

                <ul class="idsound-public_menu_content_voices_items">
                    <template x-for="character in characters">
                        <li class="" @click="setActiveCharacter(character.id)" x-bind:data-id="character.id" :class="{ 'active' : activeCharacter === character.id }" x-text="character.name"></li>
                    </template>
                </ul>
            </div>

            <div class="idsound-public_menu_content_enable">
                <span>IdSound autorisé : </span>
                <div class="" :class="{ 'active' : soundAllowed }" @click="activeSound()">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let idsound_public = document.getElementById('idsound-public');
        document.body.appendChild(idsound_public);
    });

    document.addEventListener('alpine:init', () => {
        Alpine.data('idsoundmenu', () => ({
            menuOpen: false,
            soundAllowed: false,
            play: false,
            audios: [],
            characters: [],
            activeCharacter: null,
            async init() {
                await this.testSound()
                await this.fetchAudios()
                this.audioLoop()
            },
            async testSound() {
                const default_sound = "<?= plugin_dir_url(__DIR__) ?>assets/images/default.mp3"
                try {
                    let audio = new Audio(default_sound)
                    await audio.play()
                    audio.pause()
                    this.soundAllowed = true;
                    return true;
                } catch (error) {
                    return false;
                }
            },
            async fetchAudios() {
                const request = await fetch("/wp-json/ekhos/audio/list", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': '*/*'
                    },
                    body: JSON.stringify({
                        page: "<?= $page_id ?>"
                    })
                })
                const response = await request.json()
                const audios = []
                response.items.forEach(item => {
                    const selector = document.querySelector(item.selector);
                    const a = new Audio(item.sound)
                    audios.push({
                        selector: selector,
                        character: item.character_id,
                        sound: item.sound,
                        audio: a,
                        active: false,
                        played: false,
                    })
                })
                this.audios = audios
                this.characters = response.characters
                if(this.characters) {
                    this.activeCharacter = this.characters[0].id
                }
            },
            setActiveCharacter(character) {
                this.activeCharacter = character
            },
            activeSound() {
                this.soundAllowed = true
            },
            audioLoop() {
                setInterval(() => {
                    this.playAudio()
                }, 80)
            },
            playAudio() {
                if(!this.soundAllowed) {
                    return
                }

                let closet = [undefined, undefined]

                this.audios.forEach((a) => {
                    if(!a.selector) {
                        return
                    }
                    if(a.character != this.activeCharacter) {
                        a.active = false
                        a.audio.pause()
                        a.audio.currentTime = 0
                        a.audio.onended = undefined
                        return
                    }
                    const top = a.selector.getBoundingClientRect().top
                    if((closet[0] === undefined || top>=closet[0]) && top<=0 && !a.active && !a.played){
                        closet = [top, a]
                    }
                });

                if(closet[0]) {
                    this.audios.forEach((a) => {
                        a.active = false
                        a.audio.pause()
                        a.audio.currentTime = 0
                        a.audio.onended = undefined
                    });

                    closet[1].active = true
                    closet[1].played = true
                    closet[1].audio.play()
                    closet[1].audio.onended = () => {
                        this.play = false
                    }
                    this.play = true
                }
            },
            openMenu() {
                this.menuOpen = true
            },
            closeMenu() {
                this.menuOpen = false
            },
        }))
    });
</script>

<script src="//unpkg.com/alpinejs" defer></script>