import api from "@/shared/api/axios";

export const loginRequest = async (email: string, password: string) => {
    const response = await api.post("/login", { email, password });
    return response.data;
};

export const registerRequest = async (
    name: string,
    email: string,
    password: string,
    role: "admin" | "teacher" | "student"
) => {
    const response = await api.post("/register", {
        name,
        email,
        password,
        role,
    });

    return response.data;
};