import type { Course } from "../types";

interface Props {
    course: Course;
    actionLabel?: string;
    onAction?: (courseId: number) => void;
    loading?: boolean;
    disabled?: boolean;
}

const CourseCard = ({
    course,
    actionLabel,
    onAction,
    loading = false,
    disabled = false,
}: Props) => {
    return (
        <div className="bg-white p-6 rounded-xl shadow">
            <h3 className="text-lg font-bold mb-2">
                {course.title}
            </h3>

            <p className="text-gray-600">
                {course.description}
            </p>

            {actionLabel && onAction && (
                <button
                    onClick={() => onAction(course.id)}
                    disabled={loading || disabled}
                    className={`mt-4 px-4 py-2 rounded-lg ${disabled
                            ? "bg-gray-400 cursor-not-allowed"
                            : "bg-blue-600 hover:bg-blue-700 text-white"
                        }`}
                >
                    {loading ? "Processing..." : actionLabel}
                </button>
            )}
        </div>
    );
};

export default CourseCard;