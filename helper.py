import json
import re

def load_responses():
    """Load responses from a JSON file."""
    with open('data/responses.json') as f:
        return json.load(f)

def validate_ip(ip):
    """Validate IP address format."""
    pattern = r'^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\. (25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\. (25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\. (25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$'
    return re.match(pattern, ip) is not None

def extract_ip_addresses(message):
    """Extract valid IP addresses from user input."""
    words = message.split()
    ip_addresses = [word for word in words if validate_ip(word)]
    return ip_addresses
