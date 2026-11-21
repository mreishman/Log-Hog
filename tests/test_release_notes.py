import unittest

from scripts import release_notes


class ReleaseNotesTests(unittest.TestCase):
    def test_app_notes_match_the_current_release(self):
        source = release_notes.CONFIG.read_text(encoding="utf-8")
        version = release_notes.APP_VERSION.search(source)[2]
        title, bullets = release_notes.read_notes(version)
        self.assertEqual(release_notes.expected_config(source, version, title, bullets), source)

    def test_preparing_next_version_retains_previous_app_notes(self):
        source = release_notes.CONFIG.read_text(encoding="utf-8")
        version = release_notes.APP_VERSION.search(source)[2]
        major = int(version.split(".")[0])
        next_version = f"{major + 1}.0"
        prepared = release_notes.expected_config(source, next_version, "Next release", ["Keep old notes"])
        prior_entry = source.split(release_notes.START)[1].split(release_notes.END)[0]
        self.assertIn(prior_entry, prepared.split(release_notes.START)[0])
        self.assertEqual(release_notes.APP_VERSION.search(prepared)[2], next_version)

    def test_wiki_retry_updates_only_the_matching_version(self):
        history = "### 8.5.1\n\nExisting notes\n\n## 8.5\n\nOlder notes\n"
        first = release_notes.update_wiki(history, "9.0", "Release", ["Initial notes"])
        revised = release_notes.update_wiki(first, "9.0", "Release", ["Updated notes"])
        self.assertEqual(revised, "## 9.0\n\n**Release**\n\n- Updated notes\n\n" + history)
        self.assertEqual(release_notes.update_wiki(revised, "9.0", "Release", ["Updated notes"]), revised)

    def test_wiki_retry_preserves_newer_patch_sections(self):
        first = "### 9.0.1\n\nPatch\n\n## 9.0\n\nPrevious\n\n### 8.5.1\n\nHistory\n"
        revised = release_notes.update_wiki(first, "9.0", "Release", ["Updated notes"])
        self.assertTrue(revised.startswith("### 9.0.1\n\nPatch\n\n"))
        self.assertTrue(revised.endswith("### 8.5.1\n\nHistory\n"))

    def test_missing_older_release_is_inserted_below_newer_entries(self):
        source = "### 9.0.1\n\nPatch\n\n### 8.5.1\n\nHistory\n"
        updated = release_notes.update_wiki(source, "9.0", "Release", ["Notes"])
        self.assertEqual(updated, "### 9.0.1\n\nPatch\n\n## 9.0\n\n**Release**\n\n- Notes\n\n### 8.5.1\n\nHistory\n")
