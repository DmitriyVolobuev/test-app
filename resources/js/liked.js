// new Vue({
//     el: '#app',
//     data: {
//         liked: localStorage.getItem('liked') === 'true',
//         likesCount: {{ $image->likes }},
// },
// methods: {
//     toggleLike() {
//         const likeUrl = `/{{ $image->hash }}/like`;
//         const dislikeUrl = `/{{ $image->hash }}/dislike`;
//
//         const url = this.liked ? dislikeUrl : likeUrl;
//
//         axios.post(url)
//             .then(response => {
//                 this.liked = !this.liked;
//                 const likesCountElement = document.getElementById('likes-count');
//                 if (likesCountElement) {
//                     likesCountElement.textContent = response.data.likesCount;
//
//                     localStorage.setItem('liked', this.liked.toString());
//                 }
//             })
//             .catch(error => {
//                 console.error(error);
//             });
//     }
// }
// });
