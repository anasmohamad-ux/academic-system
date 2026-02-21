import { useEffect, useState } from "react";
import api from "@/shared/api/axios";

const StudentDashboard = () => {
    const [data, setData] = useState<any>(null);

    useEffect(() => {
        api.get("/dashboard/student").then(res => {
            setData(res.data);
        });
    }, []);

    if (!data) return <p>Loading...</p>;

    return (
        <div>
            <h1 className="text-3xl font-bold mb-6">Student Dashboard</h1>

            <div className="grid grid-cols-1 gap-6">
                <Card title="My Enrolled Courses" value={data.totalCourses} />
            </div>
        </div>
    );
};

const Card = ({ title, value }: any) => (
    <div className="bg-white p-6 rounded-xl shadow">
        <h2 className="text-2xl font-bold">{value}</h2>
        <p className="text-gray-600">{title}</p>
    </div>
);

export default StudentDashboard;