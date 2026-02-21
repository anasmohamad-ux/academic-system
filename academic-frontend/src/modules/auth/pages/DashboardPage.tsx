import { useAuth } from "../context/AuthContext";
import AdminDashboard from "../../auth/dashboards/pages/AdminDashboard";
import TeacherDashboard from "../../auth/dashboards/pages/TeacherDashboard";
import StudentDashboard from "../../auth/dashboards/pages/StudentDashboard";




const DashboardPage = () => {
    const { user } = useAuth();   // 🔥 THIS LINE IS REQUIRED

    // console.log(user); // optional debug

    if (!user) return <p>Loading...</p>;

    if (user.role === "admin") return <AdminDashboard />;
    if (user.role === "teacher") return <TeacherDashboard />;
    if (user.role === "student") return <StudentDashboard />;

    return <p>No role found</p>;
};

export default DashboardPage;