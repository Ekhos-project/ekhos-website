class LiveReload{
    constructor(url='') {
        this.url = url;
        this.events();
    }

    async setNewStyle() {
        const newStyle = await this.getCurrentStyle();
        localStorage.setItem(this.url, newStyle);
        return newStyle;
    }

    async getLastStyle() {
        const style = localStorage.getItem(this.url);
        if (style !== null) {
            return style;
        } else {
            return await this.setNewStyle();
        }
    }

    async getCurrentStyle() {
        const response = await fetch(this.url);
        const data = await response.text();
        return data;
    }

    async stylesIsSame() {
        const currentStyle = await this.getCurrentStyle();
        const lastStyle = await this.getLastStyle();
        if (currentStyle === lastStyle) {
            return true;
        }
        return false;
    }

    async events() {
         setInterval(async () => {
            const isSame = await this.stylesIsSame();
            if (!isSame){
                await this.setNewStyle();
                location.reload();
            }
        }, 1000);
    }
}

export default function () {
    const styles = [
        "/wp-content/themes/ekhos/assets/styles/style.css"
    ];
    styles.forEach((style) => {
        const liveReload = new LiveReload(style);
    })

}
