import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { registerRequest } from "../api/authApi";
import { useAuth } from "../context/AuthContext";

const RegisterPage = () => {
    const navigate = useNavigate();
    const { login } = useAuth();

    const [form, setForm] = useState({
        name: "",
        email: "",
        password: "",
        role: "student",
    });

    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        setForm({
            ...form,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);
        setError("");

        try {
            const data = await registerRequest(
                form.name,
                form.email,
                form.password,
                form.role as any
            );

            localStorage.setItem("token", data.token);

            await login(form.email, form.password);

            navigate("/dashboard");
        } catch (err: any) {
            setError("Registration failed");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">
            <div className="bg-white p-8 rounded-xl shadow w-96">
                <h2 className="text-2xl font-bold mb-6 text-center">
                    Register
                </h2>

                {error && (
                    <p className="text-red-600 mb-4 text-sm">{error}</p>
                )}

                <form onSubmit={handleSubmit} className="space-y-4">
                    <input
                        type="text"
                        name="name"
                        placeholder="Name"
                        required
                        onChange={handleChange}
                        className="w-full border px-3 py-2 rounded-lg"
                    />

                    <input
                        type="email"
                        name="email"
                        placeholder="Email"
                        required
                        onChange={handleChange}
                        className="w-full border px-3 py-2 rounded-lg"
                    />

                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        required
                        onChange={handleChange}
                        className="w-full border px-3 py-2 rounded-lg"
                    />

                    <select
                        name="role"
                        onChange={handleChange}
                        className="w-full border px-3 py-2 rounded-lg"
                    >
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>

                    <button
                        type="submit"
                        disabled={loading}
                        className="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg"
                    >
                        {loading ? "Creating..." : "Register"}
                    </button>
                </form>

                <p className="text-sm mt-4 text-center">
                    Already have an account?{" "}
                    <Link to="/" className="text-blue-600">
                        Login
                    </Link>
                </p>
            </div>
        </div>
    );
};

export default RegisterPage;