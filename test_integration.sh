#!/bin/bash

# AUSHVERA Integration Test Script
# Tests all API endpoints and admin-frontend connections

API_BASE="http://localhost:8000/api"
TOKEN=""

echo "🧪 AUSHVERA Integration Test Suite"
echo "=================================="
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Test counter
PASSED=0
FAILED=0

# Helper function to test endpoint
test_endpoint() {
    local name=$1
    local method=$2
    local endpoint=$3
    local data=$4
    local auth=$5
    
    echo -n "Testing: $name... "
    
    if [ "$auth" = "true" ]; then
        if [ -z "$TOKEN" ]; then
            echo -e "${YELLOW}SKIPPED${NC} (No auth token)"
            return
        fi
        if [ "$method" = "GET" ]; then
            response=$(curl -s -w "\n%{http_code}" -H "Authorization: Bearer $TOKEN" "$API_BASE$endpoint")
        else
            response=$(curl -s -w "\n%{http_code}" -X $method -H "Content-Type: application/json" -H "Authorization: Bearer $TOKEN" -d "$data" "$API_BASE$endpoint")
        fi
    else
        if [ "$method" = "GET" ]; then
            response=$(curl -s -w "\n%{http_code}" "$API_BASE$endpoint")
        else
            response=$(curl -s -w "\n%{http_code}" -X $method -H "Content-Type: application/json" -d "$data" "$API_BASE$endpoint")
        fi
    fi
    
    http_code=$(echo "$response" | tail -n1)
    body=$(echo "$response" | head -n-1)
    
    if [ "$http_code" -ge 200 ] && [ "$http_code" -lt 300 ]; then
        echo -e "${GREEN}✓ PASSED${NC} (HTTP $http_code)"
        PASSED=$((PASSED + 1))
    else
        echo -e "${RED}✗ FAILED${NC} (HTTP $http_code)"
        echo "   Response: $body"
        FAILED=$((FAILED + 1))
    fi
}

echo "1. Testing Public Endpoints (No Auth Required)"
echo "----------------------------------------------"

test_endpoint "Get Products" "GET" "/products" "" "false"
test_endpoint "Get Banners" "GET" "/banners" "" "false"

echo ""
echo "2. Testing Authentication"
echo "-------------------------"

# Register test user
TIMESTAMP=$(date +%s)
TEST_EMAIL="test_$TIMESTAMP@example.com"
REGISTER_DATA="{\"name\":\"Test User\",\"email\":\"$TEST_EMAIL\",\"password\":\"password123\"}"

echo -n "Testing: Register User... "
response=$(curl -s -w "\n%{http_code}" -X POST -H "Content-Type: application/json" -d "$REGISTER_DATA" "$API_BASE/register")
http_code=$(echo "$response" | tail -n1)
body=$(echo "$response" | head -n-1)

if [ "$http_code" -ge 200 ] && [ "$http_code" -lt 300 ]; then
    echo -e "${GREEN}✓ PASSED${NC} (HTTP $http_code)"
    TOKEN=$(echo "$body" | grep -o '"token":"[^"]*' | cut -d'"' -f4)
    echo "   Token: ${TOKEN:0:20}..."
    PASSED=$((PASSED + 1))
else
    echo -e "${RED}✗ FAILED${NC} (HTTP $http_code)"
    FAILED=$((FAILED + 1))
fi

# Login test
LOGIN_DATA="{\"email\":\"$TEST_EMAIL\",\"password\":\"password123\"}"
echo -n "Testing: Login User... "
response=$(curl -s -w "\n%{http_code}" -X POST -H "Content-Type: application/json" -d "$LOGIN_DATA" "$API_BASE/login")
http_code=$(echo "$response" | tail -n1)
body=$(echo "$response" | head -n-1)

if [ "$http_code" -ge 200 ] && [ "$http_code" -lt 300 ]; then
    echo -e "${GREEN}✓ PASSED${NC} (HTTP $http_code)"
    TOKEN=$(echo "$body" | grep -o '"token":"[^"]*' | cut -d'"' -f4)
    PASSED=$((PASSED + 1))
else
    echo -e "${RED}✗ FAILED${NC} (HTTP $http_code)"
    FAILED=$((FAILED + 1))
fi

echo ""
echo "3. Testing Authenticated Endpoints"
echo "-----------------------------------"

test_endpoint "Get Current User" "GET" "/user" "" "true"
test_endpoint "Get Cart" "GET" "/cart" "" "true"
test_endpoint "Get Cart Count" "GET" "/cart/count" "" "true"
test_endpoint "Get My Orders" "GET" "/orders" "" "true"

echo ""
echo "4. Testing Cart Operations"
echo "--------------------------"

CART_DATA='{"product_id":1,"quantity":2}'
test_endpoint "Add to Cart" "POST" "/cart/add" "$CART_DATA" "true"
test_endpoint "Get Cart After Add" "GET" "/cart" "" "true"

echo ""
echo "5. Testing Coupon Validation"
echo "-----------------------------"

COUPON_DATA='{"code":"SAVE20"}'
test_endpoint "Validate Coupon" "POST" "/coupons/validate" "$COUPON_DATA" "false"

echo ""
echo "6. Testing Review Operations"
echo "----------------------------"

REVIEW_DATA='{"product_id":1,"rating":5,"comment":"Great product!"}'
test_endpoint "Submit Review" "POST" "/reviews" "$REVIEW_DATA" "true"
test_endpoint "Get Product Reviews" "GET" "/products/1/reviews" "" "false"

echo ""
echo "7. Testing Checkout"
echo "-------------------"

CHECKOUT_DATA='{"shipping_address":"123 Test St","phone":"1234567890"}'
test_endpoint "Checkout" "POST" "/checkout" "$CHECKOUT_DATA" "true"

echo ""
echo "=================================="
echo "Test Summary"
echo "=================================="
echo -e "Passed: ${GREEN}$PASSED${NC}"
echo -e "Failed: ${RED}$FAILED${NC}"
echo "Total: $((PASSED + FAILED))"
echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}✓ All tests passed!${NC}"
    exit 0
else
    echo -e "${RED}✗ Some tests failed${NC}"
    exit 1
fi
