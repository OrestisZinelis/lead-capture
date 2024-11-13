export const validateName = (name: string) => {
    if (!name.trim()) {
        return "Full name is required.";
    } else {
        return "";
    }
};

export const validateEmail = (email: string) => {
    if (!email) {
        return "Email is required.";
    } else if (
        !/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
            email
        )
    ) {
        return "Email must be a valid email address.";
    } else {
        return "";
    }
};
