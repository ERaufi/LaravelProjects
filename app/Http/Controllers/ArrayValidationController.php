<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArrayValidationController extends Controller
{
    //

    /**
     * Validate that 'emails' is an array with 2-5 elements
     *
     * Demo JSON:
     * {
     *   "emails": ["test1@example.com", "test2@example.com"]
     * }
     */
    public function validateEmailsArray(Request $request)
    {
        $validated = $request->validate([
            'emails' => 'required|array|min:2|max:5',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate 'emails' array, each element must be unique and a valid email
     *
     * Demo JSON:
     * {
     *   "emails": ["test1@example.com", "test2@example.com", "test3@example.com"]
     * }
     */
    public function validateUniqueEmailsArray(Request $request)
    {
        $validated = $request->validate([
            'emails' => 'required|array|min:2|max:5',
            'emails.*' => 'required|email|distinct',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate each email in the 'emails' array with custom error messages
     *
     * Demo JSON:
     * {
     *   "emails": ["valid@example.com", "invalid-email"]
     * }
     */
    public function validateEmailsCustomMessages(Request $request)
    {
        $validated = $request->validate([
            'emails' => 'required|array|min:2|max:5',
            'emails.*' => 'required|email',
        ], [
            'emails.required' => 'Please provide at least one email address.',
            'emails.*.email' => 'Each email address must be valid.',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate 'items' array with custom position-based error messages
     *
     * Demo JSON:
     * {
     *   "items": [1, -2, "three"]
     * }
     */
    public function validateItemsWithPosition(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
            'items.*' => ['integer', 'min:1'],
        ], [
            'items.*.integer' => 'The :attribute at position :position must be an integer.',
            'items.*.min' => 'The :attribute at position :position must be at least :min.',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate 'settings' object with nested keys
     *
     * Demo JSON:
     * {
     *   "settings": {
     *     "email": "user@example.com",
     *     "notification": true
     *   }
     * }
     */
    public function validateSettings(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.email' => 'required|email',
            'settings.notification' => 'required|boolean',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate 'products' array with nested objects
     *
     * Demo JSON:
     * {
     *   "products": [
     *     {
     *       "name": "Product 1",
     *       "price": 100,
     *       "quantity": 2
     *     },
     *     {
     *       "name": "Product 2",
     *       "price": -50,
     *       "quantity": 0
     *     }
     *   ]
     * }
     */
    public function validateProducts(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.name' => 'required|string',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate a simple array of strings with distinct elements
     *
     * Demo JSON:
     * {
     *   "tags": ["laravel", "php", "api", "laravel"]
     * }
     */
    public function validateTagsArray(Request $request)
    {
        $validated = $request->validate([
            'tags' => 'required|array|min:2',
            'tags.*' => 'required|string|distinct',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate a list of files
     *
     * Demo JSON:
     * {
     *   "files": ["file1.jpg", "file2.png"]
     * }
     */
    public function validateFiles(Request $request)
    {
        $validated = $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimes:jpg,png,jpeg|max:2048',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate nested arrays with additional constraints
     *
     * Demo JSON:
     * {
     *   "user": {
     *     "name": "John Doe",
     *     "addresses": [
     *       {
     *         "city": "New York",
     *         "postal_code": "10001"
     *       },
     *       {
     *         "city": "Los Angeles",
     *         "postal_code": "90001"
     *       }
     *     ]
     *   }
     * }
     */
    public function validateNestedArrays(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required|array',
            'user.name' => 'required|string|max:255',
            'user.addresses' => 'required|array|min:1',
            'user.addresses.*.city' => 'required|string|max:100',
            'user.addresses.*.postal_code' => 'required|string|size:5',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate a nested array with dynamic key names
     *
     * Demo JSON:
     * {
     *   "data": {
     *     "item1": {
     *       "value": 123,
     *       "quantity": 10
     *     },
     *     "item2": {
     *       "value": 456,
     *       "quantity": 20
     *     }
     *   }
     * }
     */
    public function validateDynamicNestedArrays(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.value' => 'required|numeric',
            'data.*.quantity' => 'required|integer|min:1',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate a nested array with conditional rules
     *
     * Demo JSON:
     * {
     *   "profile": {
     *     "email": "user@example.com",
     *     "age": 25,
     *     "extra_info": {
     *       "bio": "Hello!",
     *       "twitter_handle": "@user"
     *     }
     *   }
     * }
     */
    public function validateConditionalNestedArrays(Request $request)
    {
        $validated = $request->validate([
            'profile' => 'required|array',
            'profile.email' => 'required|email',
            'profile.age' => 'required|integer|min:18',
            'profile.extra_info' => 'sometimes|array',
            'profile.extra_info.bio' => 'sometimes|string|max:255',
            'profile.extra_info.twitter_handle' => 'sometimes|string|regex:/^@/',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate deeply nested arrays
     *
     * Demo JSON:
     * {
     *   "organization": {
     *     "departments": [
     *       {
     *         "name": "IT",
     *         "employees": [
     *           {
     *             "name": "Alice",
     *             "email": "alice@example.com"
     *           },
     *           {
     *             "name": "Bob",
     *             "email": "bob@example.com"
     *           }
     *         ]
     *       }
     *     ]
     *   }
     * }
     */
    public function validateDeeplyNestedArrays(Request $request)
    {
        $validated = $request->validate([
            'organization' => 'required|array',
            'organization.departments' => 'required|array|min:1',
            'organization.departments.*.name' => 'required|string|max:100',
            'organization.departments.*.employees' => 'required|array|min:1',
            'organization.departments.*.employees.*.name' => 'required|string|max:100',
            'organization.departments.*.employees.*.email' => 'required|email',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }

    /**
     * Validate arrays with custom rules for different keys
     *
     * Demo JSON:
     * {
     *   "settings": {
     *     "theme": "dark",
     *     "notifications": {
     *       "email": true,
     *       "sms": false
     *     }
     *   }
     * }
     */
    public function validateCustomRulesForNestedArrays(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.theme' => 'required|string|in:dark,light',
            'settings.notifications' => 'required|array',
            'settings.notifications.email' => 'required|boolean',
            'settings.notifications.sms' => 'required|boolean',
        ]);

        return response()->json(['message' => 'Validation passed!', 'data' => $validated]);
    }
}
