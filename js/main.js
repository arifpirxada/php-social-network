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