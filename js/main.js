// api functions

const follow = async (followerId, userId) => {
    try {
        const userData = {
            "user_id": userId,
            "follower_id": followerId
        }
        const jsonData = JSON.stringify(userData);
        const response = await fetch("api/follow.php", {
            method: "POST",
            body: jsonData,
            headers: {
                "Content-Type": "application/json"
            }
        });
        const data = await response.json();

        if (data && data.success) {
            window.location.href = window.location.href;
        } else {
            alert("Internal server error!")
        }
    } catch (e) {
        alert(e)
        alert("An error occured while following");
    }
}

const unfollow = async (followerId, userId) => {
    try {
        const userData = {
            "user_id": userId,
            "follower_id": followerId
        }
        const jsonData = JSON.stringify(userData);
        const response = await fetch("api/unfollow.php", {
            method: "POST",
            body: jsonData,
            headers: {
                "Content-Type": "application/json"
            }
        });
        const data = await response.json();

        if (data && data.success) {
            window.location.href = window.location.href;
        } else {
            alert("Internal server error!")
        }
    } catch (e) {
        alert("An error occured while unfollowing");
    }
}

const like = async (e, userId, postId) => {
    try {
        const likeData = {
            "user_id": userId,
            "post_id": postId
        }
        const jsonData = JSON.stringify(likeData);
        const response = await fetch(`api/like.php`, {
            method: "POST",
            body: jsonData,
            headers: {
                "Content-Type": "application/json"
            }
        });
        const data = await response.json();

        if (data && data.success) {
            let likes = parseInt(e.children[1].innerText);
            e.onclick = () => unlike(e, userId, postId);
            e.children[1].innerText = isNaN(likes) ? "1" : likes + 1;
            e.children[0].src = "img/icons/liked-icon.png"
        } else {
            alert("Internal server error!")
        }
    } catch (e) {
        alert("An error occured while liking");
    }
}

const unlike = async (e, userId, postId) => {
    try {
        const likeData = {
            "user_id": userId,
            "post_id": postId
        }
        const jsonData = JSON.stringify(likeData);
        const response = await fetch(`api/unlike.php`, {
            method: "POST",
            body: jsonData,
            headers: {
                "Content-Type": "application/json"
            }
        });
        const data = await response.json();

        if (data && data.success) {
            let likes = parseInt(e.children[1].innerText);
            e.onclick = () => like(e, userId, postId);
            e.children[1].innerText = likes - 1;
            e.children[0].src = "img/icons/like-icon.png"
        } else {
            alert("Internal server error!")
        }
    } catch (e) {
        alert("An error occured while unliking!");
    }
}

const deletePost = async (postId) => {
    try {
        const jsonData = JSON.stringify({
            "post_id": postId
        });
        const response = await fetch(`api/delete-post.php`, {
            method: "POST",
            body: jsonData,
            headers: {
                "Content-Type": "application/json"
            }
        });
        const data = await response.json();
        console.log(data)

        if (data && data.success) {
            alert("Your post has been deleted. You will be redirected profile page in 3 seconds");

            setTimeout(() => {
                window.location.href = "profile.php";
            }, 3000);

        } else {
            alert("Internal server error!")
        }
    } catch (e) {
        alert("An error occured while deleting post!", e);
    }
}