export default function () {
    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
    const category = params.get('category');
    const blogs = document.querySelectorAll(".section-blog#blog .blog_card");


    blogs.forEach((blog) => {
        if (!category) {
            blog.style.display = "flex";
            console.log("ixi")
        } else {
            const blogCategory = blog.querySelector(".blog_card_content_category").getAttribute('data-slug');
            if(blogCategory == category){
                blog.style.display = "flex";
            }
        }
    })

}
