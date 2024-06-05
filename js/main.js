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

const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    }).catch((e) => {
        alert("An error occured while coping: ", e)
    })
}


// Handle recent user operations here =>

const addToRecent = async (userId, recentUserId, isSearched) => {
    if (userId == recentUserId) {
        alert("you can't message yourself!");
        return;
    }
    if (!isSearched) {
        window.location.href = `message.php?message_user_id=${recentUserId}`
        return;
    }

    try {
        const jsonData = JSON.stringify({
            "user_id": userId,
            "recent_user_id": recentUserId
        });
        const response = await fetch(`api/add-to-recent.php`, {
            method: "POST",
            body: jsonData,
            headers: {
                "Content-Type": "application/json"
            }
        });
        const data = await response.json();

        if (data && data.success) {
            window.location.href = `message.php?message_user_id=${recentUserId}`
        } else {
            alert("Internal server error!")
        }
    } catch (e) {
        console.log(e);
        alert("An error occured while adding user to recents")
    }
}

const removeFromRecent = async (userId, recentUserId) => {
    if (userId == recentUserId) {
        return;
    }

    try {
        const jsonData = JSON.stringify({
            "user_id": userId,
            "recent_user_id": recentUserId
        });
        const response = await fetch(`api/remove-from-recent.php`, {
            method: "POST",
            body: jsonData,
            headers: {
                "Content-Type": "application/json"
            }
        });
        const data = await response.json();

        if (data && data.success) {
            window.location.href = `message.php`
        } else {
            alert("Internal server error!")
        }
    } catch (e) {
        console.log(e);
        alert("An error occured while removing user from recents")
    }
}

const deleteMessages = async (senderId, receiverId) => {
    if (senderId == receiverId) {
        return;
    }

    if (!confirm("This will delete all the messages you sent. Do you want to proceed?")) {
        return;
    }

    try {
        const jsonData = JSON.stringify({
            "sender_id": senderId,
            "receiver_id": receiverId
        });
        const response = await fetch(`api/delete-messages.php`, {
            method: "POST",
            body: jsonData,
            headers: {
                "Content-Type": "application/json"
            }
        });
        const data = await response.json();

        if (data && data.success) {
            window.location.href = `message.php`
        } else {
            alert("Internal server error!")
        }
    } catch (e) {
        console.log(e);
        alert("An error occured while deleting messages")
    }
}

const deleteNotification = async (notificationId, type, refrenceId, userId) => {
    try {
        let notifyData = {
            "notification_id": notificationId,
            "type": type
        };
        if (type == "message") {
            notifyData = {
                "notification_id": notificationId,
                "type": type,
                "user_id": userId,
                "refrence_id": refrenceId
            }
        }

        const jsonData = JSON.stringify(notifyData);
        const response = await fetch(`api/delete-notification.php`, {
            method: "POST",
            body: jsonData,
            headers: {
                "Content-Type": "application/json"
            }
        });
        const data = await response.json();

        if (data && data.success) {
            if (type == "message") {
                window.location.href = `message.php?message_user_id=${refrenceId}`;
            } else if (type == "like") {
                window.location.href = `posts.php?post_id=${refrenceId}`;
            } else if (type == "comment") {
                window.location.href = `posts.php?post_id=${refrenceId}`;
            }
        } else {
            alert("Internal server error!")
        }
    } catch (e) {
        console.log(e);
        alert("An error occured while deleting notifications!")
    }
}