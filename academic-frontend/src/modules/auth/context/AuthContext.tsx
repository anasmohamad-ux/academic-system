import { createContext, useContext, useState, useEffect } from "react";
import type { ReactNode } from "react";
import { loginRequest } from "../api/authApi";
import api from "@/shared/api/axios";

type Role = "admin" | "teacher" | "student";

interface User {
    id: number;
    name: string;
    role: Role;
}

interface AuthContextType {
    user: User | null;
    login: (email: string, password: string) => Promise<void>;
    logout: () => void;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export const AuthProvider = ({ children }: { children: ReactNode }) => {
    const [user, setUser] = useState<User | null>(null);
    const [loading, setLoading] = useState(true);

    // 🔥 Restore session on refresh
    useEffect(() => {
        const token = localStorage.getItem("token");

        if (!token) {
            setLoading(false);
            return;
        }

        api.get("/me")
            .then((res) => {
                setUser(res.data);
            })
            .catch(() => {
                localStorage.removeItem("token");
                setUser(null);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    const login = async (email: string, password: string) => {
        const data = await loginRequest(email, password);

        localStorage.setItem("token", data.token);

        setUser({
            id: data.user.id,
            name: data.user.name,
            role: data.user.role,
        });
    };

    const logout = () => {
        localStorage.removeItem("token");
        setUser(null);
    };

    if (loading) return null; // optional: spinner

    return (
        <AuthContext.Provider value={{ user, login, logout }}>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = () => {
    const context = useContext(AuthContext);
    if (!context) {
        throw new Error("useAuth must be used within AuthProvider");
    }
    return context;
};