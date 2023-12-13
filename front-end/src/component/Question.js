import React, { useEffect, useState } from "react";
import axios from "axios";
import Swal from 'sweetalert2';
import { useNavigate } from 'react-router-dom'
import { API_BASE_URL } from './common/Constant';

const Question = () => {
    const navigate = useNavigate();

    const [question, setQuestion] = useState({
        question: '',
        answers: [''], // Array to hold answers
        category_id: '',
    });

    const [category, setCategory] = useState([]);
    const [validationError, setValidationError] = useState({})
    const [isSubmitting, setIsSubmitting] = useState(false);

    const token = localStorage.getItem('token');
    const config = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'headers': { Authorization: `Bearer ${token}` }
    };

    useEffect(() => {
        if (!token) {
            navigate('/login');
        }
        const fetchData = async () => {
            await axios.get(`${API_BASE_URL}get_categories`, null, config).then(({ data }) => {
                setCategory(data.data);
            }).catch(({ response }) => {
                if (response.status === 422) {
                    alert(response.data.errors)
                } else {
                    Swal.fire({
                        text: response.data.message,
                        icon: "error"
                    })
                }
            })
        }

        fetchData();
    }, [token]);

    const handleChange = (e) => {
        const { name, value, type } = e.target;
        if (name === 'answers') {
            const answers = [...question.answers];
            answers[parseInt(value.index)] = value.value;
            setQuestion({ ...question, [name]: answers });
        } else {
            setQuestion({ ...question, [name]: value });
        }
    };

    const addAnswer = () => {
        setQuestion({ ...question, answers: [...question.answers, ''] });
    };

    const removeAnswer = (index) => {
        const answers = [...question.answers];
        answers.splice(index, 1);
        setQuestion({ ...question, answers });
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        setIsSubmitting(true);
    
        const formData = new FormData();
        formData.append('question', question.question);
        formData.append('category_id', question.category_id);
        question.answers.forEach((answer, index) => {
            formData.append(`answers[${index}]`, answer);
        });
    
        axios.post(`${API_BASE_URL}add_question`, formData, config)
            .then(function (response) {
                setQuestion({
                    question: '',
                    answers: [''],
                    category_id: '',
                });
    
                Swal.fire({
                    icon: "success",
                    text: response.data.message
                });
                navigate("/login");
                setIsSubmitting(false);
            })
            .catch((error) => {
                if (error.response && error.response.status === 422) {
                    setValidationError(error.response.data.errors)
                } else if (error.response) {
                    Swal.fire({
                        text: error.response.data.message,
                        icon: "error"
                    });
                } else {
                    // Handle other types of errors
                    console.error("Unexpected error:", error);
                }
                setIsSubmitting(false);
            });
    }
    

    return (
        <>
            <div className="container mt-4">
                <div className="row justify-content-center">
                    <div className="col-md-6">
                        <div className="card p-4">
                            <h1 className="text-center mb-3">Add Question </h1>
                            {
                                Object.keys(validationError).length > 0 && (
                                    <div className="row">
                                        <div className="col-12">
                                            <div className="alert alert-danger">
                                                <ul className="mb-0">
                                                    {
                                                        Object.entries(validationError).map(([key, value]) => (
                                                            <li key={key}>{value}</li>
                                                        ))
                                                    }
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                )
                            }
                            <form onSubmit={handleSubmit}>
                                <div className="form-group">
                                    <label>Question:</label>
                                    <input type="text" name="question" className="form-control" placeholder="Enter question" value={question.name} onChange={handleChange} />
                                </div>
                                <div className="form-group">
                                    <label>Category:</label>
                                    <select className="form-control" name="category_id" onChange={handleChange}>
                                        <option value="">---Select Category---</option>
                                        {
                                            category.map((cat) => {
                                                return <option key={cat.id} value={cat.id}>{cat.name}</option>
                                            })
                                        }
                                    </select>
                                </div>
                                <div className="form-group">
                                    <label>Answers:</label>
                                    {question.answers.map((answer, index) => (
                                        <div key={index} className="d-flex mb-2">
                                            <textarea name="answers" className="form-control" placeholder={`Enter answer ${index + 1}`} value={answer} onChange={(e) => handleChange({ target: { name: 'answers', value: { index, value: e.target.value } } })}></textarea>
                                            <button type="button" className="btn btn-danger ml-2" onClick={() => removeAnswer(index)}>Remove</button>
                                        </div>
                                    ))}
                                    <button type="button" className="btn btn-secondary mt-2" onClick={addAnswer}>Add Answer</button>
                                </div>
                                <button type="submit" className="btn btn-primary mt-4" disabled={isSubmitting}>
                                    {isSubmitting ? 'Submitting...' : 'Submit'}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Question;
