class TrieNode:
    def __init__(self):
        self.children = {}
        self.is_end_of_word = False
        self.value = None

class Trie:
    def __init__(self):
        self.root = TrieNode()

    def insert(self, key, value):
        """Insert a key-value pair into the Trie."""
        node = self.root
        for char in key:
            if char not in node.children:
                node.children[char] = TrieNode()
            node = node.children[char]
        node.is_end_of_word = True
        node.value = value

    def search(self, key):
        """Search for a key in the Trie and return its value if found."""
        node = self.root
        for char in key:
            if char not in node.children:
                return None
            node = node.children[char]
        return node.value if node.is_end_of_word else None

    def autocomplete(self, prefix):
        """Return all keys in the Trie that start with the given prefix."""
        node = self.root
        for char in prefix:
            if char not in node.children:
                return []
            node = node.children[char]

        return self._find_words(node)

    def _find_words(self, node):
        """Helper function to find all words from a given Trie node."""
        words = []
        if node.is_end_of_word:
            words.append(node.value)

        for child in node.children.values():
            words.extend(self._find_words(child))

        return words