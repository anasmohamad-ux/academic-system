import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { createCourse } from "../api/courseApi";

const CreateCoursePage = () => {
    const navigate = useNavigate();

    const [title, setTitle] = useState("");
    const [description, setDescription] = useState("");
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();

        try {
            setLoading(true);

            await createCourse({
                title,
                description,
            });

            navigate("/dashboard/courses");
        } catch (error) {
            console.error("Failed to create course");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="max-w-xl">
            <h1 className="text-3xl font-bold mb-6">
                Create Course
            </h1>

            <form onSubmit={handleSubmit} className="space-y-4 bg-white p-6 rounded-xl shadow">
                <div>
                    <label className="block mb-1 font-medium">
                        Title
                    </label>
                    <input
                        type="text"
                        className="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value={title}
                        onChange={(e) => setTitle(e.target.value)}
                        required
                    />
                </div>

                <div>
                    <label className="block mb-1 font-medium">
                        Description
                    </label>
                    <textarea
                        className="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value={description}
                        onChange={(e) => setDescription(e.target.value)}
                        required
                    />
                </div>

                <button
                    type="submit"
                    disabled={loading}
                    className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50"
                >
                    {loading ? "Creating..." : "Create Course"}
                </button>
            </form>
        </div>
    );
};

export default CreateCoursePage;
