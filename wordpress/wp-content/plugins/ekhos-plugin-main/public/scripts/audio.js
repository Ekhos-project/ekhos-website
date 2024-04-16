class AudioSound {
    constructor() {
        this.active = false;
        this.play = false;
        this.popup = this.addPopup();
        this.audios = [];
        this.getAudios();
        this.lastUpdate = new Date();
        this.update();
    }

    async soundAllowed() {
        const d = document.getElementById("audio_sound-default");
        const url = d.getAttribute("data-url");
        try {
            let audio = new Audio(url);
            await audio.play();
            return true;
        } catch (error) {
            return false;
        }
        return false;
    }

    async addPopup() {
        const allowed = await this.soundAllowed();
        if(allowed) {
            this.active = true;
            return;
        }
        const popup = document.createElement("div");
        const html = "<span>Ce site utilise des sons pour augmenter l'expérience utilisateur.</span>" +
            "<button>Accepter</button>"
        popup.innerHTML = html;
        popup.id = "audio_sound-popup";
        document.body.appendChild(popup);
        popup.querySelector("button").addEventListener("click", () => {
            this.active = true;
            this.popup = undefined;
            popup.remove();
        })
        return popup;
    }

    async getAudios() {
        let page = document.getElementById("audio_sound-pageid");
        page = page.getAttribute("data-pageid")
        try {
            const request = await fetch(`/wp-json/ekhos/audio/list`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': '*/*'
                },
                body: JSON.stringify({
                    page: page
                })
            });
            const response = await request.json();
            this.appendAudios(response.items);
        } catch (error) {
        }
    }

    appendAudios(audios) {
        console.log(audios);
        audios.forEach((audio) => {
            const selector = document.querySelector(audio.selector);
            if (selector && audio.current) {
                const a = new Audio(audio.sound)
                this.audios.push({
                    selector: selector,
                    sound: audio.sound,
                    audio: a,
                    active: false,
                    played: false,
                })
            }
        });
    }

    update() {
        const currentUpdate = new Date();

        window.requestAnimationFrame(() => {
            this.update();
        });

        if ((currentUpdate - this.lastUpdate) < 80) {
            return;
        }

        this.lastUpdate = currentUpdate;
        this.playAudioSelector();
    }

    playAudioSelector() {
        if (!this.active) return;
        let closet = [undefined, undefined];

        this.audios.forEach((a) => {
            const top = a.selector.getBoundingClientRect().top;
            if((closet[0] === undefined || top>=closet[0]) && top<=0 && !a.active && !a.played){
                closet = [top, a];
                console.log(a)
            }
        });

        if(closet[0]) {
            this.audios.forEach((a) => {
                a.active = false;
                a.audio.pause();
                a.audio.currentTime = 0;
                a.audio.onended = undefined;
            });

            closet[1].active = true;
            closet[1].played = true;
            closet[1].audio.play();
            closet[1].audio.onended = () => {
                this.play = false ;
            }
            this.play = true;
        }else {
            /*if(!this.play){
                this.audios.forEach((a) => {
                    a.active = false;
                    a.played = false;
                    a.audio.pause();
                    a.audio.currentTime = 0;
                    a.audio.onended = undefined;
                });
            }*/
        }
    }
}

export default function () {
    const audio = new AudioSound();
}
