import { NavLink, Outlet } from "react-router-dom";
import { useAuth } from "../../modules/auth/context/AuthContext";

const MainLayout = () => {
    const { user, logout } = useAuth();

    return (
        <div className="min-h-screen flex">
            {/* Sidebar */}
            <aside className="w-64 bg-gray-800 text-white p-6 flex flex-col justify-between">
                <div>
                    <h2 className="text-xl font-bold mb-6">
                        Academic System
                    </h2>

                    <nav className="space-y-2">
                        <NavLink
                            to="/dashboard"
                            end
                            className={({ isActive }) =>
                                `block px-3 py-2 rounded-lg transition ${isActive
                                    ? "bg-blue-600 text-white"
                                    : "hover:bg-gray-700"
                                }`
                            }
                        >
                            Dashboard
                        </NavLink>

                        <NavLink
                            to="/dashboard/courses"
                            className={({ isActive }) =>
                                `block px-3 py-2 rounded-lg transition ${isActive
                                    ? "bg-blue-600 text-white"
                                    : "hover:bg-gray-700"
                                }`
                            }
                        >
                            Courses
                        </NavLink>

                        {/* Student Only */}
                        {user?.role === "student" && (
                            <NavLink
                                to="/dashboard/my-courses"
                                className={({ isActive }) =>
                                    `block px-3 py-2 rounded-lg transition ${isActive
                                        ? "bg-blue-600 text-white"
                                        : "hover:bg-gray-700"
                                    }`
                                }
                            >
                                My Courses
                            </NavLink>
                        )}
                    </nav>
                </div>

                {/* Logout Section */}
                <div className="border-t border-gray-700 pt-4">
                    <p className="text-sm mb-2">
                        Logged in as:
                        <br />
                        <span className="font-semibold">
                            {user?.name}
                        </span>
                    </p>

                    <button
                        onClick={logout}
                        className="w-full bg-red-600 hover:bg-red-700 px-3 py-2 rounded-lg text-white transition"
                    >
                        Logout
                    </button>
                </div>
            </aside>

            {/* Content */}
            <main className="flex-1 bg-gray-100 p-8">
                <Outlet />
            </main>
        </div>
    );
};

export default MainLayout;